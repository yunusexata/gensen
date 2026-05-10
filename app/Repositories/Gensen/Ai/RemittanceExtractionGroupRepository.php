<?php

namespace App\Repositories\Gensen\Ai;

use App\Models\Gensen\Ai\RemittanceExtractionGroup;
use App\Repositories\MasterDataRepository;

class RemittanceExtractionGroupRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return RemittanceExtractionGroup::class;
    }

    public static function datatable()
    {
        return RemittanceExtractionGroup::query();
    }
}
