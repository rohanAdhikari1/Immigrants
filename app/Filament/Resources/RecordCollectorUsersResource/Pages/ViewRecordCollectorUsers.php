<?php

namespace App\Filament\Resources\RecordCollectorUsersResource\Pages;

use App\Filament\Resources\RecordCollectorUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRecordCollectorUsers extends ViewRecord
{
    protected static string $resource = RecordCollectorUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
