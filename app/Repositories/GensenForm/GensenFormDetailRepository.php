<?php

namespace App\Repositories\GensenForm;

use App\Models\GensenForm\GensenFormDetail;
use App\Repositories\MasterDataRepository;

class GensenFormDetailRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenFormDetail::class;
    }
}
