<?php

namespace App\Repositories\Dashboard;

use App\Models\GensenForm\GensenForm;
use App\Repositories\MasterDataRepository;
use Carbon\Carbon;

class DashboardRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenForm::class;
    }

    // MONTHLY SUMMARY
    public static function transactionMonthly(?Carbon $month = null)
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        return GensenForm::query()
            ->selectRaw("
            DATE(created_at) as transaction_date,
            pic_code,
            COUNT(*) as total
        ")
            ->whereBetween('created_at', [$start, $end])
            ->groupByRaw("
            DATE(created_at),
            pic_code
        ")
            ->orderBy('transaction_date')
            ->get();
    }
}
