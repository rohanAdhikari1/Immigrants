<?php

namespace App\Filament\Resources\DistrictUserResource\Pages;

use App\Filament\Resources\DistrictUserResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateDistrictUser extends CreateRecord
{
    protected static string $resource = DistrictUserResource::class;

    protected function afterCreate(): void
    {
        $this->record->user->assignRole('district');
        $this->record->created_by = Filament::auth()->user()->id;
    }
}
