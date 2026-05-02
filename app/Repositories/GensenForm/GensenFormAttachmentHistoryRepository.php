<?php

namespace App\Repositories\GensenForm;

use App\Models\GensenForm\GensenFormAttachmentHistory;
use App\Repositories\MasterDataRepository;

class GensenFormAttachmentHistoryRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenFormAttachmentHistory::class;
    }

    public static function datatable()
    {
        return GensenFormAttachmentHistory::query();
    }
}
