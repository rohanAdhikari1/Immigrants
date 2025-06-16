<?php

namespace App\Filament\Resources\InformationProviderResource\Pages;

use App\Filament\Resources\InformationProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageInformationProviders extends ManageRecords
{
    protected static string $resource = InformationProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
