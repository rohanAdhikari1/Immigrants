<?php

namespace App\Filament\Resources\MuncipalityUsersResource\Pages;

use App\Filament\Resources\MuncipalityUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMuncipalityUsers extends ListRecords
{
    protected static string $resource = MuncipalityUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
