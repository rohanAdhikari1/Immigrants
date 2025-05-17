<?php

namespace App\Filament\Resources\MuncipalityResource\Pages;

use App\Filament\Resources\MuncipalityResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMuncipalities extends ManageRecords
{
    protected static string $resource = MuncipalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
