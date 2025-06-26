<?php

namespace App\Livewire;

use App\Models\ReturnedMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReturnedMigrantCurrentOccupationReport extends Component
{
    public $currentOccupationData = [];
    public $currentOccupationPercentage = [];

    public function mount()
    {

        $this->currentOccupationData = ReturnedMigrantWorker::select('current_occupation', DB::raw('COUNT(*) as total_count'))
            ->groupBy('current_occupation')
            ->orderBy('total_count')
            ->pluck('total_count', 'current_occupation')->toArray();
        $total = ReturnedMigrantWorker::count();

        $this->currentOccupationPercentage = ReturnedMigrantWorker::select(
            'current_occupation',
            DB::raw('COUNT(*) * 100.0 / ' . $total . ' as percentage')
        )
            ->groupBy('current_occupation')
            ->pluck('percentage', 'current_occupation')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.returned-migrant-current-occupation-report');
    }
}
