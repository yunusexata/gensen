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

    public static function datatable()
    {
        return IchijikinExtractionFile::query();
    }
}
