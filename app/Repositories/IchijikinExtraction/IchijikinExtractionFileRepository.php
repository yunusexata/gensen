<?php

namespace App\Repositories\IchijikinExtraction;

use App\Models\Ichijikin\IchijikinExtractionFile;
use App\Repositories\MasterDataRepository;

class IchijikinExtractionFileRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return IchijikinExtractionFile::class;
    }

    public static function datatable($objId = null)
    {
        return IchijikinExtractionFile::query()
            ->select(
                'ichijikin_extraction_files.id',
                'results.nama_lengkap',
                'results.no_nenkin',
                'results.lama_kerja',
                'results.nenkin_100',
                'results.nenkin_80',
                'results.nenkin_20',
                'results.type',
            )
            ->leftJoin(
                'ichijikin_extraction_results as results',
                'results.ichijikin_extraction_file_id',
                '=',
                'ichijikin_extraction_files.id'
            )
            ->when($objId, function ($q) use ($objId) {
                $q->where('ichijikin_extraction_files.ichijikin_extraction_id', '=', $objId);
            });
    }
}
