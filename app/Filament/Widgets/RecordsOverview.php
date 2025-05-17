<?php

namespace App\Filament\Widgets;

use App\Models\Farmer;
use App\Models\FarmerRecord;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecordsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [];
        // if (auth()->user()?->hasRole('user')) {
        //     return [
        //         Stat::make('Total Records', FarmerRecord::where('is_approved', 1)->where('created_by', auth()->user()?->id)->count()),
        //         Stat::make('Total Farmers',  Farmer::where('created_by', auth()->user()?->id)->count()),
        //     ];
        // } elseif (auth()->user()?->hasRole('Muncipality')) {
        //     return [
        //         Stat::make('Total Records', FarmerRecord::where('is_approved', 1)->where('muncipality_id', auth()->user()?->muncipality_id)->count()),
        //         Stat::make('Total Farmers',  Farmer::where('muncipality_id', auth()->user()?->muncipality_id)->count()),
        //     ];
        // } elseif (auth()->user()?->hasRole('district')) {
        //     return [
        //         Stat::make('Total Records', FarmerRecord::where('is_approved', 1)->where('district_id', auth()->user()?->district_id)->count()),
        //         Stat::make('Total Farmers',  Farmer::where('district_id', auth()->user()?->district_id)->count()),
        //     ];
        // } else {
        //     return [
        //         Stat::make('Total Records', FarmerRecord::where('is_approved', 1)->count()),
        //         Stat::make('Total Farmers',  Farmer::count()),
        //     ];
        // }
    }
}
