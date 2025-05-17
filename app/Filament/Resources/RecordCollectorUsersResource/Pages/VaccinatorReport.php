<?php

namespace App\Filament\Resources\RecordCollectorUsersResource\Pages;

use App\Filament\Resources\RecordCollectorUsersResource;
use App\Models\DataEntryUser;
use Livewire\Attributes\Locked;
use Filament\Resources\Pages\Page;

class VaccinatorReport extends Page
{

    protected static string $resource = RecordCollectorUsersResource::class;

    protected static string $view = 'filament.resources.record-collector-users-resource.pages.vaccinator-report';

    #[Locked]
    public int | null $vaccinator;

    public $activeTab = 'tab1';

    public int $price = 100;

    public DataEntryUser $user;

    public function mount(int $record): void
    {
        $this->vaccinator = $record;
        $this->user =  DataEntryUser::find($this->vaccinator);
    }
}
