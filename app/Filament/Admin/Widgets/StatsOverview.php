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
        // Mengambil semua data order sesuai status
        $orders = Order::where('status', Success::$name)->get();

        // Mendapatkan total sum dari kolom 'total'
        $totalSum = formatCurrency($orders->sum('total'));

        // Mendapatkan total jumlah order
        $total = $orders->count();

        // Mendapatkan array dari nilai kolom 'total' untuk digunakan dalam chart
        $chartData = $orders->pluck('total')->toArray();

        return [
            Stat::make('Total Customers', Customer::count()),
            Stat::make('Total Product', Product::count()),
            Stat::make('Total Transaksi', $totalSum)
            ->description('Total Transaksi')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart($chartData)
                ->color('success'),
        ];
    }
}