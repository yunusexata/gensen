<?php

namespace App\Repositories\Ai;

use App\Models\Ai\AiJob;
use App\Repositories\MasterDataRepository;

class AiJobRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return AiJob::class;
    }

    public static function datatable()
    {
        return AiJob::query();
    }
}
