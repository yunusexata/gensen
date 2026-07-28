<?php

namespace App\Repositories\ListPosting;

use App\Models\ListPosting\ListPosting;
use App\Repositories\MasterDataRepository;

class ListPostingRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return ListPosting::class;
    }

    public static function datatable()
    {
        return ListPosting::query();
    }
}
