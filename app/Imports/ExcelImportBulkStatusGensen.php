<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImportBulkStatusGensen implements ToCollection, WithHeadingRow, WithChunkReading
{
    public $rows;

    public function collection(Collection $rows)
    {
        $this->rows = $rows;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
