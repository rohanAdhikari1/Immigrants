<?php

namespace App\Filament\Widgets;

use App\Models\DataEntryUser;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class RecordCollectorRecordsStat extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $title = 'Record Collector Report';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                DataEntryUser::query()->withCount(
                    [
                        'currentMigrantWorkers as no_of_current_migrant_worker',
                        'returnedMigrantWorkers as no_of_returned_migrant_worker'
                    ]
                )
            )
            ->columns([
                TextColumn::make('first_name'),
                TextColumn::make('middle_name'),
                TextColumn::make('last_name'),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('no_of_current_migrant_worker')
                    ->label('No of current migrant records'),
                TextColumn::make('no_of_returned_migrant_worker')
                    ->label('No of returned migrant records'),
                TextColumn::make('total_records')
                    ->label('No of total records')
                    ->state(function (Model $record): float {
                        return $record->no_of_current_migrant_worker + $record->no_of_returned_migrant_worker;
                    }),
            ]);
    }
}
