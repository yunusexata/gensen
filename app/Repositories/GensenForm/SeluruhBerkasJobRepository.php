<?php

namespace App\Repositories\GensenForm;

use App\Models\GensenForm\SeluruhBerkasJob;
use App\Repositories\MasterDataRepository;

class SeluruhBerkasJobRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return SeluruhBerkasJob::class;
    }

    public static function datatable()
    {
        return SeluruhBerkasJob::query();
    }
}
