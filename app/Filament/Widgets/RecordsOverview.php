<?php

namespace App\Filament\Widgets;

use App\Models\CurrentMigrantWorker;
use App\Models\Farmer;
use App\Models\FarmerRecord;
use App\Models\ReturnedMigrantWorker;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecordsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        if (auth()->user()?->hasRole('user')) {
            return [
                Stat::make('Total Current Migrants', CurrentMigrantWorker::where('created_by', auth()->id)->count()),
                Stat::make('Total Retunred Migrants',  ReturnedMigrantWorker::where('created_by', auth()->id)->count()),
            ];
        } elseif (auth()->user()?->hasRole('Muncipality')) {
            return [];
        } elseif (auth()->user()?->hasRole('district')) {
            return [];
        } else {
            return [
                Stat::make('Total Current Migrants', CurrentMigrantWorker::count()),
                Stat::make('Total Retunred Migrants',  ReturnedMigrantWorker::count()),
            ];
        }
    }
}
