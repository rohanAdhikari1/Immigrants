<?php

namespace App\Livewire;

use App\Models\ReturnedMigrantWorker;
use Livewire\Component;

class Table3 extends Component
{

    public $totalMale = [];
    public $totalFemale = [];
    public $wards = [];

    public function mount()
    {
        $this->totalMale = ReturnedMigrantWorker::where('gender', 'male')->count();
        $this->totalFemale = ReturnedMigrantWorker::where('gender', 'female')->count();
    }
    public function render()
    {
        return view('livewire.table3');
    }
}
