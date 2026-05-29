<?php

namespace App\Repositories\IchijikinExtraction;

use App\Models\Ichijikin\IchijikinExtraction;
use App\Repositories\MasterDataRepository;

class IchijikinExtractionRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return IchijikinExtraction::class;
    }

    public static function datatable()
    {
        return IchijikinExtraction::query();
    }
}
