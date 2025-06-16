<?php

namespace App\Livewire;

use App\Models\ReturnedMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReturnedMigrantWorkerMaritialReport extends Component
{
    public $martitialData = [];
    public $martitialPercentage = [];

    public function mount()
    {

        $this->martitialData = ReturnedMigrantWorker::select('maritial_status', DB::raw('COUNT(*) as total_count'))
            ->groupBy('maritial_status')
            ->orderBy('total_count')
            ->pluck('total_count', 'maritial_status')->toArray();
        $totalWorkers = ReturnedMigrantWorker::count();

        $this->martitialPercentage = ReturnedMigrantWorker::select(
            'maritial_status',
            DB::raw('COUNT(*) * 100.0 / ' . $totalWorkers . ' as percentage')
        )
            ->groupBy('maritial_status')
            ->pluck('percentage', 'maritial_status')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.returned-migrant-worker-maritial-report');
    }
}
