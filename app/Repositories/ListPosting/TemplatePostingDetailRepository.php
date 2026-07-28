<?php

namespace App\Repositories\ListPosting;

use App\Models\ListPosting\TemplatePostingDetail;
use App\Repositories\MasterDataRepository;

class TemplatePostingDetailRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return TemplatePostingDetail::class;
    }

    public static function datatable()
    {
        return TemplatePostingDetail::query();
    }
}
