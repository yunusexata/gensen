<?php

namespace App\Repositories\GensenForm;

use App\Models\GensenForm\GensenFormDetailLog;
use App\Repositories\MasterDataRepository;

class GensenFormDetailLogRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenFormDetailLog::class;
    }
}
