<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\States\OrderStatus\Success;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $totalSum = formatCurrency(Order::where('status', Success::$name)->sum('total'));
        $total = Order::count();
        return [
            Stat::make('Total Customers', Customer::count()),
            Stat::make('Total Product', Product::count()),
            Stat::make('Total Transaksi', $totalSum)
                ->description('Jumlah Transaksi')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([$total])
                ->color('success'),
        ];
    }
}
