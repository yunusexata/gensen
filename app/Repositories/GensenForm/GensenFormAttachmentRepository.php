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

    public static function datatableTrash($search = null)
    {
        $query = GensenFormAttachment::onlyTrashed()
            ->with([
                'gensenForm' => function ($q) {
                    $q->withTrashed();
                },
                'deletedByUser'
            ]);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'ILIKE', "%{$search}%")
                    ->orWhere('stored_name', 'ILIKE', "%{$search}%")
                    ->orWhere('note', 'ILIKE', "%{$search}%")
                    ->orWhere('type', 'ILIKE', "%{$search}%")
                    ->orWhereHas('gensenForm', function ($qForm) use ($search) {
                        $qForm->withTrashed()->where('nama_lengkap', 'ILIKE', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    public static function restore($id)
    {
        $attachment = GensenFormAttachment::onlyTrashed()->find($id);
        return $attachment ? $attachment->restore() : false;
    }

    public static function forceDelete($id)
    {
        $attachment = GensenFormAttachment::onlyTrashed()->find($id);
        return $attachment ? $attachment->forceDelete() : false;
    }
}
