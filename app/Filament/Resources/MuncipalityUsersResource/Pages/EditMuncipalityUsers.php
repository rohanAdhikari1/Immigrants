<?php

namespace App\Filament\Resources\MuncipalityUsersResource\Pages;

use App\Filament\Resources\MuncipalityUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMuncipalityUsers extends EditRecord
{
    protected static string $resource = MuncipalityUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
