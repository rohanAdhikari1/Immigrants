<?php

namespace App\Filament\Resources\MuncipalityUsersResource\Pages;

use App\Filament\Resources\MuncipalityUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMuncipalityUsers extends ViewRecord
{
    protected static string $resource = MuncipalityUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
