<?php

namespace App\Repositories\GensenForm;

use App\Models\GensenForm\PersyaratanGensenJob;
use App\Repositories\MasterDataRepository;

class PersyaratanGensenJobRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return PersyaratanGensenJob::class;
    }

    public static function datatable()
    {
        return PersyaratanGensenJob::query();
    }
}
