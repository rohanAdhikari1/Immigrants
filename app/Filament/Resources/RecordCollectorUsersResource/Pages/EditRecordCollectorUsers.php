<?php

namespace App\Filament\Resources\RecordCollectorUsersResource\Pages;

use App\Filament\Resources\RecordCollectorUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecordCollectorUsers extends EditRecord
{
    protected static string $resource = RecordCollectorUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
