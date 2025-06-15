<?php

namespace App\Filament\Resources\ReturnedMigrantWorkerResource\Pages;

use App\Filament\Resources\ReturnedMigrantWorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReturnedMigrantWorkers extends ListRecords
{
    protected static string $resource = ReturnedMigrantWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
