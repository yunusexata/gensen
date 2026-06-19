<?php

namespace App\Jobs\ResiGenerator;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GenerateReceiptImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Tentukan agar Job ini otomatis membaca ulang model dari DB saat dieksekusi
     */
    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle(): void
    {
        // 1. Ambil data JSON hasil parsing dari database
        $parsedData = $this->transaction->email_parsed;

        // Jika data json kosong atau gagal parsing sebelumnya, batalkan job
        if (empty($parsedData)) {
            return;
        }

        // 2. Compile HTML template Blade dengan parameter data parsed
        // File template diletakkan di: resources/views/templates/receipt.blade.php
        $htmlContent = view('templates.receipt', ['data' => $parsedData])->render();

        // 3. Tentukan nama file unik dan path penyimpanan (Local & VPS Safe)
        $filename = 'receipt_' . $this->transaction->id . '_' . time() . '.jpg';
        $storagePath = storage_path('app/public/receipts/' . $filename);

        // Pastikan folder 'receipts' sudah terbuat di storage
        if (!file_exists(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }

        // 4. Jalankan perintah render HTML menjadi Image menggunakan Browsershot
        Browsershot::html($htmlContent)
            ->noSandbox() // Mencegah crash hak akses di Ubuntu VPS
            ->addChromiumArguments([
                '--disable-dev-shm-usage', // Menghemat shared memory VPS agar tidak crash
                '--disable-setuid-sandbox',
                '--no-first-run',
                '--headless'
            ])
            ->setScreenshotType('jpeg', 90)
            ->windowSize(540, 600) // Atur resolusi kotak struk bank Anda
            ->deviceScaleFactor(2) // Membuat teks struk tetap tajam (High DPI)
            ->save($storagePath);

        // 5. Update baris database dengan path gambar yang baru saja disimpan
        $this->transaction->update([
            'generated_image_path' => 'receipts/' . $filename
        ]);
    }
}
