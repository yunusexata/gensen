<?php

namespace App\Repositories\ResiGenerator;

use App\Models\ResiGenerator\ResiGeneratorEmail;
use App\Repositories\MasterDataRepository;

class ResiGeneratorEmailRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return ResiGeneratorEmail::class;
    }

    public static function datatable($objId = null)
    {
        return ResiGeneratorEmail::query();
    }
}
