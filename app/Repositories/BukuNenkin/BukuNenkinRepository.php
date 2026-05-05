<?php

namespace App\Repositories\BukuNenkin;

use App\Models\BukuNenkin\BukuNenkin;
use App\Repositories\MasterDataRepository;

class BukuNenkinRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return BukuNenkin::class;
    }

    public static function datatable()
    {
        return BukuNenkin::query();
    }
}
