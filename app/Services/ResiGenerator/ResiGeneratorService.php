<?php

namespace App\Services\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Models\ResiGenerator\ResiGenerator;
use App\Repositories\ResiGenerator\ResiGeneratorDetailRepository;
use App\Repositories\ResiGenerator\ResiGeneratorEmailRepository;
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
                $logoPathBNI = 'data:image/png;base64,' .
                    base64_encode(
                        file_get_contents(
                            public_path('images/resi-generator/logo_bni.png')
                        )
                    );
                $headerPathBRI = 'data:image/png;base64,' .
                    base64_encode(
                        file_get_contents(
                            public_path('images/resi-generator/bri_header.png')
                        )
                    );
                $header2PathBRI = 'data:image/png;base64,' .
                    base64_encode(
                        file_get_contents(
                            public_path('images/resi-generator/bri_header2.png')
                        )
                    );
                $footerPathBRI = 'data:image/png;base64,' .
                    base64_encode(
                        file_get_contents(
                            public_path('images/resi-generator/bri_footer.png')
                        )
                    );
                foreach ($allEmails as $email) {
                    if ($model->bank == ResiGenerator::BANK_BNI) {
                        $updatedHtmlBody = str_ireplace(
                            'src="CID:bnilogo.png"',
                            'src="' . $logoPathBNI . '"',
                            $email['html_body']
                        );
                    } elseif ($model->bank == ResiGenerator::BANK_BRI) {
                        $s3HeaderUrl = "https://s3.brimo.bri.co.id/ibbiz-asset/assets/email/email-header-master.png";
                        $s3Header2Url = "https://s3.brimo.bri.co.id/ibbiz-asset/assets/email/email-header-2.png";
                        $s3FooterUrl = "https://s3.brimo.bri.co.id/ibbiz-asset/assets/email/email-footer.png";
                        // 1. Buat array pencarian (search)
                        $search = [
                            "url('$s3HeaderUrl')",
                            "url('$s3Header2Url')",
                            "url('$s3FooterUrl')"
                        ];

                        // 2. Buat array pengganti (replace)
                        $replace = [
                            "url('$headerPathBRI')",
                            "url('$header2PathBRI')",
                            "url('$footerPathBRI')"
                        ];

                        // 3. Lakukan replace sekaligus
                        $updatedHtmlBody = str_replace($search, $replace, $email['html_body']);
                    } else {
                        $updatedHtmlBody = $email['html_body'];
                    }
                    $validateData = [
                        'resi_generator_id' => $model->id,
                        'email_received_at' => $email['date'],
                        'email_subject' => $email['subjek'],
                        'email_sender' => $email['dari'],
                        'email_body_raw' => $email['body'],
                        'email_html' => $updatedHtmlBody,
                        'email_parsed' => $email['parsed'],

                        'formatted_nominal' => $email['parsed']['formatted_nominal'],
                        'formatted_rekening_tujuan' => $email['parsed']['formatted_rekening_tujuan'],
                        'formatted_penerima' => $email['parsed']['formatted_penerima'],
                    ];

                    ResiGeneratorEmailRepository::create($validateData);
                }

                logger(
                    [
                        'message' => 'Berhasil mengambil ' . $result['total'] . ' data email.',
                    ]
                );
                return  $result['total'];
            }
        } else {
            return 0;
        }
    }

    public function BCAparse(string $body): array
    {

        $data = [
            'no_referensi'  => $this->matchPattern('/No Referensi\s*:\s*(\d+)/i', $body),
            // Ekstrak Tanggal dan Jam secara terpisah karena format BCA memisahkannya
            'tanggal' => $this->matchPattern('/Tanggal\s*:\s*([^\n\r]+)/i', $body),
            'jam'     => $this->matchPattern('/Jam\s*:\s*([^\n\r]+)/i', $body),
            'nominal' => $this->matchPattern('/Nominal\s*:\s*([^\n\r]+)/i', $body) ?? '',
            'pengirim'       => $this->matchPattern('/Pengirim\s*:\s*([^\n\r]+)/i', $body),
            'rekening_tujuan' => $this->matchPattern('/Rekening Tujuan\s*:\s*([^\n\r]+)/i', $body) ?? '',
            'berita'          => $this->matchPattern('/Berita\s*:\s*([\s\S]+?)(?=\n\s*Catatan\s*:|$)/i', $body),

            // FORMATTED DATA
            'formatted_nominal' => (int) str_replace(
                ['Rp', '.', ' '],
                '',
                $this->matchPattern('/Nominal\s*:\s*([^\n\r]+)/i', $body) ?? ''
            ),
            'formatted_rekening_tujuan' => preg_replace(
                '/\D/',
                '',
                $this->matchPattern('/Rekening Tujuan\s*:\s*([^\n\r]+)/i', $body) ?? ''
            ),
            'formatted_penerima' => '',
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
            'no_referensi_bni' => $this->matchPattern('/No\. Referensi BNI\s*:\s*(\d+)/i', $body),
            'no_referensi_customer' => $this->matchPattern('/No\. Referensi Customer\s*:\s*(\d+)/i', $body),
            'tanggal_jam' => $this->matchPattern('/Tanggal\/Jam\s*:\s*([^\n]+)/i', $body),
            'nominal' => $this->matchPattern('/Nominal\s*:\s*([^\n]+)/i', $body),
            'pengirim' => $this->matchPattern('/Pengirim\s*:\s*([^\n]+)/i', $body),
            'penerima' => $this->matchPattern('/Penerima\s*:\s*([^\n]+)/i', $body),
            'keterangan_pembayaran' => $this->matchPattern('/Keterangan Pembayaran\s*:\s*([^\n]+)/i', $body),
            'status' => $this->matchPattern('/Status\s*:\s*([^\n]+)/i', $body),

            // FORMATTED DATA
            'formatted_nominal' => (int) str_replace(
                ['IDR', ',', '.00', ' '],
                '',
                $this->matchPattern('/Nominal\s*:\s*([^\n\r]+)/i', $body)
            ),
            'formatted_rekening_tujuan' => trim(explode('-', $this->matchPattern('/Penerima\s*:\s*([^\n]+)/i', $body), 2)[0] ?? ''),
            'formatted_penerima' => trim(
                str_replace(
                    ['Bpk', 'Sdr', 'Sdri'],
                    '',
                    explode('-', $this->matchPattern('/Penerima\s*:\s*([^\n]+)/i', $body), 2)[1]
                )
                    ?? ''
            ),
        ];

        return $data;
    }
    public function BRIparse(string $body): array
    {
        $data = [
            'rekening_debit'  => $this->matchPattern('/Rekening Debit\s*:\s*([^\n\r]+)/i', $body),
            'rekening_kredit' => $this->matchPattern('/Rekening Kredit\s*:\s*([^\n\r]+)/i', $body),
            'nominal'         => $this->matchPattern('/Nominal\s*:\s*([^\n\r]+)/i', $body),
            'catatan'         => $this->matchPattern('/Catatan\s*:\s*([^\n\r]+)/i', $body),
            // Mengambil status yang berada di baris baru
            'status'          => $this->matchPattern('/Status\s*:\s*[\r\n]+([a-zA-Z]+)/i', $body),

            // FORMATTED DATA
            'formatted_nominal' => (int) str_replace(
                ['IDR', '.', ',00', ' '],
                '',
                $this->matchPattern('/Nominal\s*:\s*([^\n\r]+)/i', $body)
            ),
            'formatted_rekening_tujuan' => trim(explode('-', $this->matchPattern('/Rekening Kredit\s*:\s*([^\n\r]+)/i', $body), 2)[0] ?? ''),
            'formatted_penerima' => trim(explode('-', $this->matchPattern('/Rekening Kredit\s*:\s*([^\n\r]+)/i', $body), 2)[1] ?? ''),
        ];

        // Membersihkan spasi di awal/akhir teks hasil ekstraksi
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }
        }

        return $data;
    }
    public function MANDIRIparse(string $body): array
    {
        $data = [
            'date_time'               => $this->matchPattern('/Date\/Time\s*:\s*([^\n\r]+)/i', $body),
            'corporate_name'          => $this->matchPattern('/Corporate Name\s*:\s*([^\n\r]+)/i', $body),
            'transaction_type'        => $this->matchPattern('/Transaction Type\s*:\s*([^\n\r]+)/i', $body),
            'from_account'            => $this->matchPattern('/From Account\s*:\s*([^\n\r]+)/i', $body),
            'to_account'              => $this->matchPattern('/To Account\s*:\s*([^\n\r]+)/i', $body),
            'beneficiary_bank'        => $this->matchPattern('/Beneficiary Bank\s*:\s*([^\n\r]+)/i', $body),
            'amount'                  => $this->matchPattern('/Amount\s*:\s*([^\n\r]+)/i', $body),
            'charge'                  => $this->matchPattern('/Charge\s*:\s*([^\n\r]+)/i', $body),
            'reference_no'            => $this->matchPattern('/Reference No\s*:\s*([^\n\r]+)/i', $body),
            'remark'                  => $this->matchPattern('/Remark\s*:\s*([^\n\r]+)/i', $body),
            'extended_payment_detail' => $this->matchPattern('/Extended Payment Detail\s*:\s*([^\n\r]+)/i', $body),

            // FORMATTED DATA
            'formatted_nominal'       => (int) str_replace(
                ['IDR', ',', '.00', ' '],
                '',
                $this->matchPattern('/Amount\s*:\s*([^\n\r]+)/i', $body)
            ),

            'formatted_rekening_tujuan' => trim(explode('- IDR -', $this->matchPattern('/To Account\s*:\s*([^\n\r]+)/i', $body), 2)[0] ?? ''),
            'formatted_penerima' => trim(explode('- IDR -', $this->matchPattern('/To Account\s*:\s*([^\n\r]+)/i', $body), 2)[1] ?? ''),
        ];

        // Membersihkan spasi berlebih di awal atau akhir teks hasil ekstraksi
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }
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
