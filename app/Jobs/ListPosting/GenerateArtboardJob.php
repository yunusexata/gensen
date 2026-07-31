<?php

namespace App\Jobs\ListPosting;

use App\Models\ListPosting\TemplatePosting;
use App\Repositories\ListPosting\TemplatePostingRepository;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver; // Atau Imagick\Driver jika Imagick tersedia di server
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\FontInterface;

class GenerateArtboardJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $namesChunk;
    protected $pageNumber;
    protected $templatePath;
    protected $templatePostingId;
    protected $listPostingId;
    protected $fontPath;
    protected $fontPathNumber;

    public function __construct(array $namesChunk, int $pageNumber, int $templatePostingId, int $listPostingId)
    {
        $this->namesChunk = $namesChunk;
        $this->pageNumber = $pageNumber;
        $this->templatePostingId = $templatePostingId;
        $this->listPostingId = $listPostingId;

        // Sesuaikan dengan lokasi font Anda
        $this->fontPath = storage_path('app/fonts/BebasNeue-Regular.otf');
    }

    public function handle()
    {
        $template = TemplatePostingRepository::find($this->templatePostingId);
        $this->templatePath = $template->path;
        if ($template->type === TemplatePosting::TYPE_LIST_PENCAIRAN) {
            $this->fontPathNumber = storage_path('app/fonts/helvetica-compressed.otf');
            $this->generateListPencairan($template, 160);
        } elseif ($template->type === TemplatePosting::TYPE_KIRIM_BERKAS) {
            $this->fontPathNumber = storage_path('app/fonts/Anton-Regular.ttf');
            $this->generateKirimBerkas($template, 105);
        }
    }

    protected function generateListPencairan($template, $chunkSize)
    {
        $disk = $template->disk; // misal: 'public' atau 'local'

        // 1. Cek apakah file benar-benar ada di storage disk tersebut
        $fileExists = Storage::disk($disk)->exists($this->templatePath);

        // Ambil absolute path (C:/dev/projects/...) untuk dilog dan dibaca oleh ImageManager
        $absolutePath = Storage::disk($disk)->path($this->templatePath);

        // 2. Tampilkan data ke logger
        Log::info('Mengecek file template artboard', [
            'template_id' => $this->templatePostingId,
            'disk'        => $disk,
            'path'        => $this->templatePath,
            'absolute'    => $absolutePath,
            'is_exists'   => $fileExists
        ]);
        // 3. Validasi: Hentikan proses jika file tidak ditemukan
        if (!$fileExists) {
            Log::error('Gagal memproses Job: File template tidak ditemukan secara fisik.', [
                'absolute_path' => $absolutePath
            ]);

            // Throw exception agar Job ini masuk ke tabel failed_jobs
            throw new \Exception("File template tidak ditemukan di path: " . $absolutePath);
        }

        // 4. Load Template
        $manager = new ImageManager(new Driver());
        $image = $manager->read($absolutePath);
        $image->resize(1080, 1440);

        // 2. Konfigurasi Grid & Tipografi (Sesuaikan pixelnya dengan resolusi template asli Anda)
        // 2. Konfigurasi Grid & Tipografi
        // Asumsi resolusi template Anda adalah sekitar 1080x1350px (Standar Portrait)
        $startX = 30;        // Margin kiri (sangat mepet dengan batas kiri artboard)
        $startY = 204;       // Margin atas (dimulai persis di bawah bayangan banner 'PERIODE')
        $columnWidth = 262;  // Lebar area per kolom (memungkinkan 4 kolom muat sejajar)
        $rowHeight = 26;   // Jarak antar baris (sangat rapat, nyaris bersentuhan)
        $maxRowsPerCol = 40; // Total baris per kolom
        $fontSize = 24;      // Ukuran font disesuaikan dengan row height

        // 3. Tulis Nama ke Artboard
        foreach ($this->namesChunk as $index => $nameData) {
            // Kalkulasi posisi kolom (0, 1, 2, 3) dan baris (0 - 39)
            $col = floor($index / $maxRowsPerCol);
            $row = $index % $maxRowsPerCol;

            $x = $startX + ($col * $columnWidth);
            $y = $startY + ($row * $rowHeight);

            // Format text: "1. NAMA PESERTA"
            // (Total max 160 per halaman sesuai 4 kolom x 40 baris)
            // $text = ($index + 1 + (($this->pageNumber - 1) * 160)) . '. ' . strtoupper($nameData);


            $text = ($index + 1 + (($this->pageNumber - 1) * $chunkSize))
                . '. '
                . mb_substr(strtoupper($nameData), 0, 19);

            $image->text($text, $x, $y, function ($font) use ($fontSize, $template) {
                $font->file($this->fontPath);
                $font->size($fontSize);

                // Warna font pada gambar referensi tidak murni hitam pekat (#000000), 
                // melainkan abu-abu sangat gelap (charcoal) agar lebih menyatu dengan background.
                $font->color($template->config['list']['color'] ?? '#000000');

                $font->align('left');
                $font->valign('top');
            });
        }
        // 4. Tulis Nomor Halaman Besar di Kiri Bawah
        $pageText = str_pad($this->pageNumber, 2, '0', STR_PAD_LEFT);
        $image->text($pageText, 40, 1380, function ($font) use ($template) {
            $font->file($this->fontPathNumber); // Bisa gunakan font style/weight berbeda jika ada
            $font->size(130);
            $font->color($template->config['page']['color'] ?? '#000000');
            $font->align('left');
            $font->valign('bottom');
        });

        // // 5. Simpan Hasil
        // $outputPath = 'public/results/page_' . $pageText . '_' . time() . '.jpg';
        // $image->save(storage_path('app/' . $outputPath), quality: 90);
        $folderPath = 'list_posting/results/task_' . $this->listPostingId; // Sesuaikan jika Anda tidak melempar taskId
        $fileName   = 'page_' . str_pad($this->pageNumber, 2, '0', STR_PAD_LEFT) . '.jpg';
        $fullPath   = $folderPath . '/' . $fileName;

        // Tentukan disk penyimpanannya (misal pakai disk public)
        $saveDisk = 'public';

        // 6. BUAT FOLDER JIKA BELUM ADA (Ini kunci penyelesaian errornya)
        if (!Storage::disk($saveDisk)->exists($folderPath)) {
            Storage::disk($saveDisk)->makeDirectory($folderPath);
            // \Log::info('Membuat direktori baru: ' . $folderPath);
        }

        // 7. Simpan Hasil
        // Ambil absolute path untuk tempat menyimpannya
        $absoluteSavePath = Storage::disk($saveDisk)->path($fullPath);
        $image->save($absoluteSavePath, quality: 90);

        // \Log::info('Berhasil menyimpan halaman artboard ke: ' . $absoluteSavePath);
    }
    protected function generateKirimBerkas($template, $chunkSize)
    {
        $disk = $template->disk; // misal: 'public' atau 'local'

        // 1. Cek apakah file benar-benar ada di storage disk tersebut
        $fileExists = Storage::disk($disk)->exists($this->templatePath);

        // Ambil absolute path (C:/dev/projects/...) untuk dilog dan dibaca oleh ImageManager
        $absolutePath = Storage::disk($disk)->path($this->templatePath);

        // 2. Tampilkan data ke logger
        Log::info('Mengecek file template artboard', [
            'template_id' => $this->templatePostingId,
            'disk'        => $disk,
            'path'        => $this->templatePath,
            'absolute'    => $absolutePath,
            'is_exists'   => $fileExists
        ]);
        // 3. Validasi: Hentikan proses jika file tidak ditemukan
        if (!$fileExists) {
            Log::error('Gagal memproses Job: File template tidak ditemukan secara fisik.', [
                'absolute_path' => $absolutePath
            ]);

            // Throw exception agar Job ini masuk ke tabel failed_jobs
            throw new \Exception("File template tidak ditemukan di path: " . $absolutePath);
        }

        // 4. Load Template
        $manager = new ImageManager(new Driver());
        $image = $manager->read($absolutePath);
        $image->resize(1080, 1920);

        // 2. Konfigurasi Grid & Tipografi (Sesuaikan pixelnya dengan resolusi template asli Anda)
        // 2. Konfigurasi Grid & Tipografi
        // Asumsi resolusi template Anda adalah sekitar 1080x1350px (Standar Portrait)
        $startX = 100;        // Margin kiri (sangat mepet dengan batas kiri artboard)
        $startY = 580;       // Margin atas (dimulai persis di bawah bayangan banner 'PERIODE')
        $columnWidth = 300;  // Lebar area per kolom (memungkinkan 4 kolom muat sejajar)
        $rowHeight = 29;   // Jarak antar baris (sangat rapat, nyaris bersentuhan)
        $maxRowsPerCol = 35; // Total baris per kolom
        $fontSize = 27;      // Ukuran font disesuaikan dengan row height

        // 3. Tulis Nama ke Artboard
        foreach ($this->namesChunk as $index => $nameData) {
            // Kalkulasi posisi kolom (0, 1, 2, 3) dan baris (0 - 39)
            $col = floor($index / $maxRowsPerCol);
            $row = $index % $maxRowsPerCol;

            $x = $startX + ($col * $columnWidth);
            $y = $startY + ($row * $rowHeight);

            // Format text: "1. NAMA PESERTA"
            // (Total max 160 per halaman sesuai 4 kolom x 40 baris)
            // $text = ($index + 1 + (($this->pageNumber - 1) * 160)) . '. ' . strtoupper($nameData);


            $text = ($index + 1 + (($this->pageNumber - 1) * $chunkSize))
                . '. '
                . mb_substr(strtoupper($nameData), 0, 21);

            $image->text($text, $x, $y, function ($font) use ($fontSize, $template) {
                $font->file($this->fontPath);
                $font->size($fontSize);

                // Warna font pada gambar referensi tidak murni hitam pekat (#000000), 
                // melainkan abu-abu sangat gelap (charcoal) agar lebih menyatu dengan background.
                $font->color($template->config['list']['color'] ?? '#000000');

                $font->align('left');
                $font->valign('top');
            });
        }
        // 4. Tulis Nomor Halaman Besar di Kiri Bawah
        $pageText = str_pad($this->pageNumber, 2, '0', STR_PAD_LEFT);
        $image->text($pageText, 870, 440, function ($font) use ($template) {
            $font->file($this->fontPathNumber); // Bisa gunakan font style/weight berbeda jika ada
            $font->size(140);
            $font->color($template->config['page']['color'] ?? '#000000');
            $font->align('left');
            $font->valign('bottom');
        });

        // // 5. Simpan Hasil
        // $outputPath = 'public/results/page_' . $pageText . '_' . time() . '.jpg';
        // $image->save(storage_path('app/' . $outputPath), quality: 90);
        $folderPath = 'list_posting/results/task_' . $this->listPostingId; // Sesuaikan jika Anda tidak melempar taskId
        $fileName   = 'page_' . str_pad($this->pageNumber, 2, '0', STR_PAD_LEFT) . '.jpg';
        $fullPath   = $folderPath . '/' . $fileName;

        // Tentukan disk penyimpanannya (misal pakai disk public)
        $saveDisk = 'public';

        // 6. BUAT FOLDER JIKA BELUM ADA (Ini kunci penyelesaian errornya)
        if (!Storage::disk($saveDisk)->exists($folderPath)) {
            Storage::disk($saveDisk)->makeDirectory($folderPath);
            // \Log::info('Membuat direktori baru: ' . $folderPath);
        }

        // 7. Simpan Hasil
        // Ambil absolute path untuk tempat menyimpannya
        $absoluteSavePath = Storage::disk($saveDisk)->path($fullPath);
        $image->save($absoluteSavePath, quality: 90);

        // \Log::info('Berhasil menyimpan halaman artboard ke: ' . $absoluteSavePath);
    }
}
