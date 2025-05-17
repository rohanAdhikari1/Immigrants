<?php

namespace App\Filament\Resources\DistrictUserResource\Pages;

use App\Filament\Resources\DistrictUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDistrictUser extends EditRecord
{
    protected static string $resource = DistrictUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
