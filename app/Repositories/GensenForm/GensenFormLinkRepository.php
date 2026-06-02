<?php

namespace App\Repositories\GensenForm;

use App\Models\GensenForm\GensenFormLink;
use App\Repositories\MasterDataRepository;
use Illuminate\Support\Facades\Auth;

class GensenFormLinkRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenFormLink::class;
    }

    public static function datatable($status)
    {
        $pic_code = Auth::user()->pic_code;
        return GensenFormLink::when($pic_code, function ($q) use ($pic_code) {
            $q->where('pic_code', $pic_code);
        })
            ->when($status == GensenFormLink::STATUS_ACTIVE, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($status == GensenFormLink::STATUS_SUCCESS, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($status == GensenFormLink::STATUS_EXPIRED, function ($q) use ($status) {
                $q->where('expired_at', '<', now());
            });
    }

    public static function incrementUsedCount($id)
    {
        return GensenFormLink::where('id', $id)
            ->increment('used_count');
    }
}
