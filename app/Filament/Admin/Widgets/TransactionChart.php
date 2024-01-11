<?php

namespace App\Filament\Admin\Widgets;

use Carbon\Carbon;
use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Transaksi';
    protected int|string|array $columnSpan = 2;

    protected static ?string $maxHeight = '300px';

    public ?string $filter = 'today';

    protected static ?string $pollingInterval = '10s';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $data = Trend::model(Order::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                    'borderColor' => [
                        'rgb(45, 200, 45)',
                    ],
                    'backgroundColor' => [
                        'rgb(45, 200, 45)',
                    ],
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->isoFormat('MMM YYYY'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
