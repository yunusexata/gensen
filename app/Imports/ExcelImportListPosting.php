<?php

namespace App\Imports;

use App\Models\ListPosting\ListPostingDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage; // Pastikan import facade Storage
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;

class ExcelImportListPosting implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue, WithEvents, WithHeadingRow
{
    protected $taskId;
    protected $filePath; // Tambahkan properti ini

    public function __construct($taskId, $filePath)
    {
        $this->taskId = $taskId;
        $this->filePath = $filePath;
    }

    public function model(array $row)
    {
        return new ListPostingDetail([
            'list_posting_id' => $this->taskId,
            'name'            => $row['nama'],
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function (AfterImport $event) {
                // 1. Panggil service untuk memulai Generate Artboard
                // app(\App\Services\ArtboardGeneratorService::class)
                //     ->generateArtboards($this->taskId);

                // 2. Hapus file Excel temporary dari storage lokal
                // if (Storage::exists($this->filePath)) {
                //     Storage::delete($this->filePath);
                // }
            },
        ];
    }
}
