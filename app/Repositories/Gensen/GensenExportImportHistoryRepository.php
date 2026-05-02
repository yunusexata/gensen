<?php

namespace App\Repositories\Gensen;

use App\Models\Gensen\GensenExportImportHistory;
use App\Repositories\MasterDataRepository;

class GensenExportImportHistoryRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenExportImportHistory::class;
    }

    public static function datatable()
    {
        return GensenExportImportHistory::query();
    }
}
