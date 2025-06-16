<?php

namespace App\Livewire;

use App\Models\Household;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WardwiseCurrentMigrantDetail extends Component
{
    public $wardWiseDataMale = [];
    public $wardWiseDataFemale = [];
    public $wards = [];

    public function mount()
    {
        $this->wards = Household::groupBy('ward_no')->pluck('ward_no')->toArray();

        $this->wardWiseDataMale = Household::query()
            ->select('households.ward_no')
            ->selectRaw('SUM(CASE WHEN current_migrant_workers.gender = ? THEN 1 ELSE 0 END) as male_migrant_worker', ['male'])
            ->leftJoin('current_migrant_workers', 'households.id', '=', 'current_migrant_workers.household_id')
            ->groupBy('households.ward_no')
            ->pluck('male_migrant_worker', 'households.ward_no')
            ->toArray();

        $this->wardWiseDataFemale = Household::query()
            ->select('households.ward_no')
            ->selectRaw('SUM(CASE WHEN current_migrant_workers.gender = ? THEN 1 ELSE 0 END) as male_migrant_worker', ['female'])
            ->leftJoin('current_migrant_workers', 'households.id', '=', 'current_migrant_workers.household_id')
            ->groupBy('households.ward_no')
            ->pluck('male_migrant_worker', 'households.ward_no')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.wardwise-current-migrant-detail');
    }
}
