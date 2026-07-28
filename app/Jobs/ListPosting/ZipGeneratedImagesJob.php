<?php

namespace App\Jobs\ListPosting;

use App\Enums\Gensen\JobStatus;
use App\Models\ListPosting\ListPosting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Throwable;

class ZipGeneratedImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskId;

    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    public function handle()
    {
        // 1. Ambil data Task
        $task = ListPosting::find($this->taskId);

        if (!$task) {
            Log::error("ZipGeneratedImagesJob: Task ID {$this->taskId} tidak ditemukan.");
            return;
        }

        try {
            // Update status bahwa proses zipping sedang berjalan
            $task->update([
                'zip_status' => JobStatus::PROCESSING,
                'zip_started_at' => now()
            ]);

            $disk = 'public'; // Sesuaikan disk tempat Anda menyimpan hasil artboard sebelumnya
            $sourceDirectory = 'list_posting/results/task_' . $task->id;

            // Konfigurasi file ZIP tujuan
            $zipFileName = 'task_artboard_' . $task->id . '_' . time() . '.zip';
            $zipDirectory = 'list_posting/zips';
            $zipFilePath = $zipDirectory . '/' . $zipFileName;

            // 2. Buat folder untuk menampung file ZIP jika belum ada
            if (!Storage::disk($disk)->exists($zipDirectory)) {
                Storage::disk($disk)->makeDirectory($zipDirectory);
            }

            // Dapatkan path absolut untuk dibaca oleh ZipArchive
            $absoluteSourcePath = Storage::disk($disk)->path($sourceDirectory);
            $absoluteZipPath = Storage::disk($disk)->path($zipFilePath);

            // 3. Validasi apakah folder sumber ada dan memiliki file
            if (!Storage::disk($disk)->exists($sourceDirectory)) {
                throw new \Exception("Direktori hasil gambar tidak ditemukan: " . $sourceDirectory);
            }

            $files = Storage::disk($disk)->files($sourceDirectory);

            if (empty($files)) {
                throw new \Exception("Tidak ada file gambar untuk di-zip pada direktori: " . $sourceDirectory);
            }

            // 4. Proses Zipping
            $zip = new ZipArchive;
            if ($zip->open($absoluteZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

                foreach ($files as $file) {
                    $absoluteFilePath = Storage::disk($disk)->path($file);

                    // Ambil nama filenya saja (misal: page_01.jpg) agar tidak membuat struktur folder panjang di dalam zip
                    $relativeNameInZip = basename($file);

                    $zip->addFile($absoluteFilePath, $relativeNameInZip);
                }

                $zip->close();
            } else {
                throw new \Exception("Gagal membuat/membuka file ZIP di: " . $absoluteZipPath);
            }

            // 5. Update Database jika sukses
            $task->update([
                'zip_path'          => $zipFilePath,
                'zip_status'        => JobStatus::DONE,
                'zip_generated_at'   => now(),
                'zip_finished_at'   => now(),
                'zip_error_message' => null,
            ]);

            Log::info("Berhasil membuat ZIP untuk Task {$task->id} di {$zipFilePath}");

            // OPSIONAL: Hapus folder gambar asli setelah di-zip untuk menghemat Storage VPS
            // Storage::disk($disk)->deleteDirectory($sourceDirectory);

        } catch (Throwable $e) {
            // 6. Tangani jika terjadi error
            Log::error("ZipGeneratedImagesJob Gagal: " . $e->getMessage());

            $task->update([
                'zip_status'        => JobStatus::FAILED,
                'zip_error_message' => $e->getMessage(),
                'zip_finished_at'   => now(),
            ]);
        }
    }
}
