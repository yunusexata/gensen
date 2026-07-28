<?php

namespace App\Repositories\ListPosting;

use App\Models\ListPosting\ListPOstingDetail;
use App\Repositories\MasterDataRepository;

class ListPOstingDetailRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return ListPOstingDetail::class;
    }

    public static function datatable()
    {
        return ListPOstingDetail::query();
    }
}
