<?php

namespace App\Services\ResiGenerator;

use App\Jobs\ResiGenerator\GenerateReceiptImageJob;
use Illuminate\Support\Str;

class ResiMatcherService
{
    public function matchByConfidenceScore($resiGenerator)
    {
        $unmatchedDetails = $resiGenerator->details()
            ->where('is_matched', false)
            ->whereNull('resi_generator_email_id')
            ->get();

        $availableEmails = $resiGenerator->emails()->get();

        foreach ($unmatchedDetails as $detail) {
            $bestMatch = null;
            $highestScore = 0;
            $bestEmailKey = null;

            foreach ($availableEmails as $key => $email) {
                // Proses komparasi ketat
                $score = $this->calculateConfidenceScore($detail, $email, strtolower($detail->bank));

                if ($score > $highestScore) {
                    $highestScore = $score;
                    $bestMatch = $email;
                    $bestEmailKey = $key;
                }
            }

            // Batasan Threshold minimal 75%
            if ($highestScore >= 75 && $bestMatch) {
                try {

                    $detail->update([
                        'is_matched' => true,
                        'resi_generator_email_id' => $bestMatch->id,
                        'confidence_score' =>  (int) round($highestScore),
                        // 'generated_image_path' => 'resi-generated/' . $$detail->resi->label . '/' . $fileName
                    ]);

                    GenerateReceiptImageJob::dispatch($detail)->onQueue('extract');

                    $availableEmails->forget($bestEmailKey);
                } catch (\Exception $e) {
                    $detail->update(['is_matched' => false]);
                    \Log::error("CRITICAL: Gagal render resi untuk {$detail->nama_penerima} - " . $e->getMessage());
                }
            } else {
                $detail->update([
                    'is_matched' => false,
                    'confidence_score' =>  (int) round($highestScore),
                    // 'generated_image_path' => 'resi-generated/' . $$detail->resi->label . '/' . $fileName
                ]);
            }
        }
    }

    /**
     * Algoritma Perhitungan Skor Utama
     */
    private function calculateConfidenceScore($excel, $email, string $bankName): float
    {
        if (empty($email)) return 0;

        // --- GATEKEEPER 1: VALIDASI NOMINAL (STRICT) ---
        $emailNominalRaw = $email['formatted_nominal'];

        if (!$this->isNominalMatch($excel->nominal, $emailNominalRaw)) {
            // Standar Bank: Jika nominal beda, langsung gagalkan (0%) tanpa perlu cek rekening/nama
            return 0;
        }

        // --- GATEKEEPER 2: VALIDASI REKENING & NAMA ---
        $emailRekening = $email['formatted_rekening_tujuan'];
        $accountScore = $this->compareAccountNumber($excel->rekening, $emailRekening);

        // Khusus BCA: Mengandalkan 100% Rekening (karena nama tidak ada di email)
        if ($bankName === 'bca') {
            return $accountScore;
        }

        // Untuk BNI, Mandiri, BRI
        $emailNama = $email['formatted_penerima'];
        $nameScore = $this->compareName($excel->nama_penerima, $emailNama);

        // Jika rekening sama sekali tidak cocok, berikan penalti ekstrem
        if ($accountScore === 0) {
            return $nameScore * 0.2;
        }

        return ($accountScore * 0.6) + ($nameScore * 0.4);
    }

    /**
     * Pembersih dan Pencocok Nominal (Kebal terhadap format Rupiah/IDR/Desimal)
     */
    private function isNominalMatch($excelNominal, $emailNominalStr): bool
    {
        // 1. Bersihkan Data Email
        $cleanEmailStr = strtolower(trim((string) $emailNominalStr));

        // Hapus simbol mata uang (idr, rp) dan spasi
        $cleanEmailStr = str_replace(['idr', 'rp', ' '], '', $cleanEmailStr);

        // Ekstrak hanya murni angka (menghilangkan titik/koma ribuan)
        $cleanEmailInt = preg_replace('/\D/', '', $cleanEmailStr);

        // 2. Bersihkan Data Excel
        // Data excel biasanya masuk sebagai float/string (misal: 17108548.00)
        $cleanExcelStr = (string) $excelNominal;
        $cleanExcelStr = preg_replace('/\.00$/', '', $cleanExcelStr);
        $cleanExcelInt = preg_replace('/\D/', '', $cleanExcelStr);

        // 3. Bandingkan (Harus identik)
        return $cleanExcelInt === $cleanEmailInt && $cleanExcelInt !== '';
    }

    private function compareAccountNumber($excelAcc, $emailAcc): int
    {
        $cleanExcel = preg_replace('/\D/', '', (string) $excelAcc);
        $cleanEmail = trim((string) $emailAcc);

        if (empty($cleanExcel) || empty($cleanEmail)) return 0;

        if ($cleanExcel === preg_replace('/\D/', '', $cleanEmail)) {
            return 100;
        }

        if (str_contains($cleanEmail, '*') || stripos($cleanEmail, 'x') !== false) {
            $visibleDigits = preg_replace('/\D/', '', $cleanEmail);
            if (!empty($visibleDigits) && strlen($visibleDigits) >= 3) {
                if (str_ends_with($cleanExcel, $visibleDigits)) {
                    return 95;
                }
            }
        }

        return 0;
    }

    private function compareName($excelName, $emailName): float
    {
        $name1 = Str::lower((string) $excelName);
        $name2 = Str::lower((string) $emailName);

        $noise = ['pt', 'cv', 'tbk', 'persero', '.', ',', '-', '- idr -', 'sdr,', 'sdri'];
        $name1 = trim(str_replace($noise, '', $name1));
        $name2 = trim(str_replace($noise, '', $name2));

        if (empty($name1) || empty($name2)) return 0;

        $similarity = 0;
        similar_text($name1, $name2, $similarity);

        return $similarity;
    }
}
