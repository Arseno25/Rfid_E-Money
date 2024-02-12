<?php

namespace App\Filament\Admin\Resources\OrderResource\Widgets;

use App\Models\Order;
use App\Models\States\OrderStatus\Failed;
use App\Models\States\OrderStatus\Success;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders Success Today', Order::ofToday()->where('status', Success::$name)->count()),
            Stat::make('Total Orders Failed Today', Order::ofToday()->where('status', Failed::$name)->count()),
            Stat::make('Total Amount Transaksi Success Today', formatCurrency(Order::ofToday()->sum('total'))),
        ];
    }
}
