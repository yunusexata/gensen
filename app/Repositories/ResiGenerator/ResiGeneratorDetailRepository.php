<?php

namespace App\Repositories\ResiGenerator;

use App\Models\ResiGenerator\ResiGeneratorDetail;
use App\Repositories\MasterDataRepository;

class ResiGeneratorDetailRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return ResiGeneratorDetail::class;
    }

    public static function datatable($objId = null)
    {
        return ResiGeneratorDetail::query();
    }
}
