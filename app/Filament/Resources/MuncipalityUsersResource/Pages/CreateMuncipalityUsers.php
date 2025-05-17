<?php

namespace App\Filament\Resources\MuncipalityUsersResource\Pages;

use App\Filament\Resources\MuncipalityUsersResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Model;

class CreateMuncipalityUsers extends CreateRecord
{
    protected static string $resource = MuncipalityUsersResource::class;

    protected function afterCreate(): void
    {
        $this->record->user->assignRole('Muncipality');
        $this->record->created_by = Filament::auth()->user()->id;
    }
}
