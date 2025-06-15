<?php

namespace App\Livewire;

use App\Models\CurrentMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Table2 extends Component
{
    public $totalMale = [];
    public $totalFemale = [];
    public $wards = [];

    public function mount()
    {
        $this->totalMale = CurrentMigrantWorker::where('gender', 'male')->count();
        $this->totalFemale = CurrentMigrantWorker::where('gender', 'female')->count();
    }

    public function render()
    {
        return view('livewire.table2');
    }
}
