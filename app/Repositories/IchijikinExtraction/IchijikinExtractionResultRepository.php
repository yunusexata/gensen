<?php

namespace App\Repositories\IchijikinExtraction;

use App\Models\Ichijikin\IchijikinExtractionResult;
use App\Repositories\MasterDataRepository;

class IchijikinExtractionResultRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return IchijikinExtractionResult::class;
    }

    public static function datatable()
    {
        return IchijikinExtractionResult::query();
    }
}
