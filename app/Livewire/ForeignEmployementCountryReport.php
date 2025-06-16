<?php

namespace App\Livewire;

use App\Models\CurrentMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ForeignEmployementCountryReport extends Component
{
    public $countryData = [];
    public $countryPercentage = [];

    public function mount()
    {

        $this->countryData = CurrentMigrantWorker::select('foreign_country', DB::raw('COUNT(*) as total_count'))
            ->groupBy('foreign_country')
            ->orderBy('total_count')
            ->pluck('total_count', 'foreign_country')->toArray();
        $totalWorkers = CurrentMigrantWorker::count();

        $this->countryPercentage = CurrentMigrantWorker::select(
            'foreign_country',
            DB::raw('COUNT(*) * 100.0 / ' . $totalWorkers . ' as percentage')
        )
            ->groupBy('foreign_country')
            ->pluck('percentage', 'foreign_country')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.foreign-employement-country-report');
    }
}
