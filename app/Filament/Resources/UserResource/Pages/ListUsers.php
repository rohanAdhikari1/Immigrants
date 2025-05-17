<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;


    public function getTabs(): array
    {
        $roles = Role::all();

        $tabs = [];
        foreach ($roles as $role) {
            $tabName = ucwords(str_replace('_', ' ', $role->name));
            $tabs[$tabName] = Tab::make($tabName)
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('roles', fn($q) => $q->where('name', $role->name)));
        }
        $tabs['all'] = Tab::make();
        return $tabs;
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
