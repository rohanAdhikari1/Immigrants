<?php

namespace App\Filament\Resources\DistrictUserResource\Pages;

use App\Filament\Resources\DistrictUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDistrictUsers extends ListRecords
{
    protected static string $resource = DistrictUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
