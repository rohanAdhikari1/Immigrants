<?php

namespace App\Filament\Resources\CurrentMigrantWorkerResource\Pages;

use App\Filament\Resources\CurrentMigrantWorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCurrentMigrantWorkers extends ListRecords
{
    protected static string $resource = CurrentMigrantWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
