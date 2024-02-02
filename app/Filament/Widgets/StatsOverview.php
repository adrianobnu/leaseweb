<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Brand;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total users', User::count()),
            Stat::make('Total assets', Asset::count()),
            Stat::make('Total brands', Brand::count()),
        ];
    }
}
