<?php

namespace App\Livewire;

use App\Models\Household;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Table4 extends Component
{
    public $wardWiseDataMale = [];
    public $wardWiseDataFemale = [];
    public $wards = [];

    public function mount()
    {
        $this->wards = Household::groupBy('ward_no')->pluck('ward_no')->toArray();

        $this->wardWiseDataMale = Household::select('ward_no', DB::raw('SUM(family_members_male_count) as total_males'))
            ->groupBy('ward_no')
            ->pluck('total_males', 'ward_no')->toArray();

        $this->wardWiseDataFemale = Household::select('ward_no', DB::raw('SUM(family_members_female_count) as total_females'))
            ->groupBy('ward_no')
            ->pluck('total_females', 'ward_no')->toArray();
    }


    public function render()
    {
        return view('livewire.table4');
    }
}
