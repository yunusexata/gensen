<?php

namespace App\Repositories\ResiGenerator;

use App\Models\ResiGenerator\ResiGenerator;
use App\Repositories\MasterDataRepository;

class ResiGeneratorRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return ResiGenerator::class;
    }

    public static function datatable()
    {
        return ResiGenerator::query();
    }
}
