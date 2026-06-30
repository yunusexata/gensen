<?php

namespace App\Repositories\Gensen;

use App\Models\Gensen\GensenSeluruhBerkasZipJob;
use App\Repositories\MasterDataRepository;

class GensenSeluruhBerkasZipJobRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenSeluruhBerkasZipJob::class;
    }
}
