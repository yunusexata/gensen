<?php

namespace App\Repositories\GensenForm;

use App\Models\GensenForm\GensenFormAttachment;
use App\Repositories\MasterDataRepository;

class GensenFormAttachmentRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenFormAttachment::class;
    }

    public static function datatable()
    {
        return GensenFormAttachment::query();
    }
}
