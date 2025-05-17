<?php

namespace App\Filament\Resources\RecordCollectorUsersResource\Pages;

use App\Filament\Resources\RecordCollectorUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecordCollectorUsers extends ListRecords
{
    protected static string $resource = RecordCollectorUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
