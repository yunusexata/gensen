<?php

namespace App\Repositories\ListPosting;

use App\Models\ListPosting\TemplatePosting;
use App\Repositories\MasterDataRepository;

class TemplatePostingRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return TemplatePosting::class;
    }

    public static function datatable()
    {
        return TemplatePosting::query();
    }
}
