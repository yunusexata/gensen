<?php

namespace App\Repositories\BukuNenkin;

use App\Models\BukuNenkin\BukuNenkinCompany;
use App\Repositories\MasterDataRepository;

class BukuNenkinCompanyRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return BukuNenkinCompany::class;
    }

    public static function datatable()
    {
        return BukuNenkinCompany::query();
    }
}
