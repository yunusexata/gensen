<?php

namespace App\Repositories\Gensen;

use App\Models\Gensen\GensenExportImportHistory;
use App\Repositories\MasterDataRepository;
use Illuminate\Support\Facades\Auth;

class GensenExportImportHistoryRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenExportImportHistory::class;
    }

    public static function datatable()
    {

        $pic_code = Auth::user()->pic_code;
        return GensenExportImportHistory::query()
            ->when($pic_code, function ($q) use ($pic_code) {
                $q->where('created_by', Auth::user()->id);
            });
    }
}
