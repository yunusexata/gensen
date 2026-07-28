<?php

namespace App\Services\ListPosting;


use App\Jobs\ListPosting\GenerateArtboardJob;
use App\Jobs\ZipGeneratedImagesJob;
use App\Models\ListPosting\ListPostingDetail;
use App\Repositories\ListPosting\ListPostingRepository;
use Illuminate\Support\Facades\Bus;
use Throwable;

class ArtboardGeneratorService
{

    public function generateArtboards($taskId)
    {
        $task = ListPostingRepository::find($taskId);

        // Update status task bahwa proses dimulai
        $task->update([
            'zip_status' => 'processing',
            'zip_started_at' => now(),
        ]);

        $jobs = [];
        $pageNumber = 1;
        $chunkSize = 160;

        // Gunakan cursor() atau chunk() dari database agar memori PHP tidak jebol 
        // jika datanya puluhan ribu.
        ListPostingDetail::where('list_posting_id', $task->id)
            ->select('name')
            ->orderBy('name', 'ASC')
            ->chunk($chunkSize, function ($names) use (&$jobs, &$pageNumber, $task) {

                // Konversi collection hasil query menjadi array flat/sederhana
                $namesArray = $names->pluck('name')->toArray();

                // Masukkan job ke dalam array
                $jobs[] = new GenerateArtboardJob(
                    $namesArray,
                    $pageNumber,
                    $task->template_posting_id, // ID template untuk get config
                    $task->id                   // Task ID untuk referensi folder nantinya
                );

                $pageNumber++;
            });

        // Jalankan Batch Job
        $batch = Bus::batch($jobs)
            ->name('Generate Artboard Task: ' . $task->name)
            ->then(function ($batch) use ($task) {
                // Semua gambar BERHASIL di-generate. 
                // Dispatch Job baru untuk men-ZIP hasilnya.
                ZipGeneratedImagesJob::dispatch($task->id);
            })
            ->catch(function ($batch, Throwable $e) use ($task) {
                // Ada Job yang GAGAL (misal template corrupt atau memori penuh)
                $task->update([
                    'zip_status' => 'failed',
                    'zip_error_message' => $e->getMessage(),
                    'zip_finished_at' => now(),
                ]);
            })
            ->dispatch();

        // Opsional: Simpan ID batch ke task Anda jika ingin melacak progress bar di UI
        // $task->update(['batch_id' => $batch->id]);

        return response()->json([
            'message' => 'Proses generate sedang berjalan di background.',
            'batch_id' => $batch->id
        ]);
    }
}
