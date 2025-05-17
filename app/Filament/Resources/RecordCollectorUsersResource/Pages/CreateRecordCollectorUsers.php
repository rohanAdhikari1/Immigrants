<?php

namespace App\Filament\Resources\RecordCollectorUsersResource\Pages;

use App\Filament\Resources\RecordCollectorUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRecordCollectorUsers extends CreateRecord
{
    protected static string $resource = RecordCollectorUsersResource::class;

    protected function afterCreate(): void
    {
        $this->record->user->assignRole('user');
    }
}
