<?php

namespace App\Repositories\Gensen\Ai;

use App\Models\Gensen\Ai\RemittanceExtraction;
use App\Repositories\MasterDataRepository;

class RemittanceExtractionRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return RemittanceExtraction::class;
    }

    public static function datatable()
    {
        return RemittanceExtraction::query();
    }
}
