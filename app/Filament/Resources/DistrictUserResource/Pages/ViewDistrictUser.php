<?php

namespace App\Filament\Resources\DistrictUserResource\Pages;

use App\Filament\Resources\DistrictUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDistrictUser extends ViewRecord
{
    protected static string $resource = DistrictUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
