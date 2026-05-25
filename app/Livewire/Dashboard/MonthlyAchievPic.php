<?php

namespace App\Livewire\Dashboard;

use App\Repositories\Dashboard\DashboardRepository;
use Carbon\Carbon;
use Livewire\Component;
use App\Traits\Livewire\WithChartJs;

class MonthlyAchievPic extends Component
{
    use WithChartJs;

    public function onMount()
    {
        $this->canvasId = 'monthly-achiev-pic';
    }

    public function getConfig(): array
    {
        return [
            'type' => 'line',
            'options' => [
                'responsive' => true,
                'plugins' => [
                    'legend' => [
                        'position' => 'top',
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Data Achievement Bulan ' . now()->format('F')
                    ]
                ]
            ]
        ];
    }

    protected function formatChartData($rows)
    {
        $dates = $rows
            ->pluck('transaction_date')
            ->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->sort()
            ->values();

        $grouped = $rows->groupBy('pic_code');

        $datasets = $grouped->map(function ($items, $picCode) use ($dates) {
            // dd($picCode);
            $mapped = $items->keyBy(function ($item) {
                return \Carbon\Carbon::parse($item->transaction_date)
                    ->format('Y-m-d');
            });

            return [
                'label' => $picCode,
                'data' => $dates->map(function ($date) use ($mapped) {
                    return $mapped[$date]->total ?? 0;
                })->values(),

                'borderWidth' => 2,
                'tension' => 0.1,

                // optional styling
                'fill' => false,
            ];
        })->values();

        return [
            'labels' => $dates,
            'datasets' => $datasets,
        ];
    }

    public function getData(): array
    {
        $monthlyData = DashboardRepository::transactionMonthly();
        $data = $this->formatChartData($monthlyData);

        return $data;
    }

    public function getView(): string
    {
        return 'livewire.livewire-chart-js';
    }
}
