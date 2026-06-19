<?php

namespace App\Services\ResiGenerator;

use App\Models\ResiGenerator\ResiGenerator;
use Illuminate\Support\Facades\Http;

class ResiGeneratorService
{
    public function getEmail(ResiGenerator $model)
    {
        // 1. Ambil nama label input dari request user/form Laravel
        $labelInput = $model->label;
        if (!$labelInput) {
            return;
        }
        // $labelInput = $request->input('label', 'Import-Bank');

        // 2. Tempel URL Web App dari Google Apps Script Langkah 2 tadi
        $appsScriptUrl = env('RESI_EMAIL_APP_SCRIPT_URL');

        // 3. Tembak API Apps Script membawa input label
        $response = Http::post($appsScriptUrl, [
            'label' => $labelInput,
            'token' => env('RESI_EMAIL_APP_SCRIPT_TOKEN')
        ]);

        if ($response->successful()) {
            $result = $response->json();

            if ($result['status'] === 'success') {
                $allEmails = $result['data']; // Ini berisi array tanggal, subjek, body email
                // Selesai! Data sudah ada di Laravel dalam bentuk Array.
                // Anda bisa looping untuk dikirim ke Gemini satu per satu:
                foreach ($allEmails as $index => $email) {
                    $textBody = $email['body'];
                    switch ($model->bank) {
                        case $model->bank == ResiGenerator::BANK_BCA:
                            $allEmails[$index]['parsed'] = $this->BCAparse($textBody);
                            break;
                        case $model->bank == ResiGenerator::BANK_BNI:
                            $allEmails[$index]['parsed'] = $this->BNIparse($textBody);
                            break;
                        case $model->bank == ResiGenerator::BANK_BRI:
                            $allEmails[$index]['parsed'] = $this->BRIparse($textBody);
                            break;
                        case $model->bank == ResiGenerator::BANK_MANDIRI:
                            $allEmails[$index]['parsed'] = $this->MANDIRIparse($textBody);
                            break;

                        default:
                            # code...
                            break;
                    }
                }

                logger(
                    [
                        'message' => 'Berhasil mengambil ' . $result['total'] . ' data email.',
                        'data' => $allEmails,
                    ]
                );

                // return response()->json([
                //     'message' => 'Berhasil mengambil ' . $result['total'] . ' data email.',
                //     'parsed' => $parsed,
                //     'data' => $allEmails,
                // ]);
            }

            // return response()->json(['error' => $result['message']], 400);
        }

        // return response()->json(['error' => 'Gagal terhubung ke Google Apps Script'], 500);
    }

    public function BCAparse(string $body): array
    {
        // Ekstrak Tanggal dan Jam secara terpisah karena format BCA memisahkannya
        $tanggal = $this->matchPattern('/Tanggal\s*:\s*([^\n\r]+)/i', $body);
        $jam     = $this->matchPattern('/Jam\s*:\s*([^\n\r]+)/i', $body);

        $data = [
            'reference_number_bca'  => $this->matchPattern('/No Referensi\s*:\s*(\d+)/i', $body),
            // Gabungkan Tanggal dan Jam agar format standar seperti BNI
            'transaction_date'      => trim($tanggal . ' ' . $jam),
            'amount_raw'            => $this->matchPattern('/Nominal\s*:\s*([^\n\r]+)/i', $body),
            'sender'                => $this->matchPattern('/Pengirim\s*:\s*([^\n\r]+)/i', $body),
            'recipient_account'     => $this->matchPattern('/Rekening Tujuan\s*:\s*([^\n\r]+)/i', $body),
            'remark'                => $this->matchPattern('/Berita\s*:\s*([^\n\r]+)/i', $body),
            // BCA tidak memiliki baris "Status", tapi template email ini menandakan transfer sukses
            'status'                => 'Berhasil',
        ];

        // Bersihkan whitespace berlebih (trim) untuk setiap data yang didapat
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }
        }

        return $data;
    }
    public function BNIparse(string $body): array
    {
        $data = [
            'reference_number_bni' => $this->matchPattern('/No\. Referensi BNI\s*:\s*(\d+)/i', $body),
            'reference_number_customer' => $this->matchPattern('/No\. Referensi Customer\s*:\s*(\d+)/i', $body),
            'transaction_date' => $this->matchPattern('/Tanggal\/Jam\s*:\s*([^\n]+)/i', $body),
            'amount_raw' => $this->matchPattern('/Nominal\s*:\s*([^\n]+)/i', $body),
            'sender' => $this->matchPattern('/Pengirim\s*:\s*([^\n]+)/i', $body),
            'recipient_raw' => $this->matchPattern('/Penerima\s*:\s*([^\n]+)/i', $body),
            'remark' => $this->matchPattern('/Keterangan Pembayaran\s*:\s*([^\n]+)/i', $body),
            'status' => $this->matchPattern('/Status\s*:\s*([^\n]+)/i', $body),
        ];

        // Clean up the Recipient Name if it contains masks (e.g., *******446 - NAME)
        if (!empty($data['recipient_raw'])) {
            $parts = explode('-', $data['recipient_raw'], 2);
            $data['recipient_name'] = trim(end($parts));
        } else {
            $data['recipient_name'] = null;
        }

        return $data;
    }
    public function BRIparse(string $body): array
    {
        $data = [
            'reference_number_bni' => $this->matchPattern('/No\. Referensi BNI\s*:\s*(\d+)/i', $body),
            'reference_number_customer' => $this->matchPattern('/No\. Referensi Customer\s*:\s*(\d+)/i', $body),
            'transaction_date' => $this->matchPattern('/Tanggal\/Jam\s*:\s*([^\n]+)/i', $body),
            'amount_raw' => $this->matchPattern('/Nominal\s*:\s*([^\n]+)/i', $body),
            'sender' => $this->matchPattern('/Pengirim\s*:\s*([^\n]+)/i', $body),
            'recipient_raw' => $this->matchPattern('/Penerima\s*:\s*([^\n]+)/i', $body),
            'remark' => $this->matchPattern('/Keterangan Pembayaran\s*:\s*([^\n]+)/i', $body),
            'status' => $this->matchPattern('/Status\s*:\s*([^\n]+)/i', $body),
        ];

        // Clean up the Recipient Name if it contains masks (e.g., *******446 - NAME)
        if (!empty($data['recipient_raw'])) {
            $parts = explode('-', $data['recipient_raw'], 2);
            $data['recipient_name'] = trim(end($parts));
        } else {
            $data['recipient_name'] = null;
        }

        return $data;
    }
    public function MANDIRIparse(string $body): array
    {
        $data = [
            'reference_number_bni' => $this->matchPattern('/No\. Referensi BNI\s*:\s*(\d+)/i', $body),
            'reference_number_customer' => $this->matchPattern('/No\. Referensi Customer\s*:\s*(\d+)/i', $body),
            'transaction_date' => $this->matchPattern('/Tanggal\/Jam\s*:\s*([^\n]+)/i', $body),
            'amount_raw' => $this->matchPattern('/Nominal\s*:\s*([^\n]+)/i', $body),
            'sender' => $this->matchPattern('/Pengirim\s*:\s*([^\n]+)/i', $body),
            'recipient_raw' => $this->matchPattern('/Penerima\s*:\s*([^\n]+)/i', $body),
            'remark' => $this->matchPattern('/Keterangan Pembayaran\s*:\s*([^\n]+)/i', $body),
            'status' => $this->matchPattern('/Status\s*:\s*([^\n]+)/i', $body),
        ];

        // Clean up the Recipient Name if it contains masks (e.g., *******446 - NAME)
        if (!empty($data['recipient_raw'])) {
            $parts = explode('-', $data['recipient_raw'], 2);
            $data['recipient_name'] = trim(end($parts));
        } else {
            $data['recipient_name'] = null;
        }

        return $data;
    }

    private function matchPattern(string $pattern, string $text): ?string
    {
        if (preg_match($pattern, $text, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }
}
