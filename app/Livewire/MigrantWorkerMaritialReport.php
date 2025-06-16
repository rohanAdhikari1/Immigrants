<?php

namespace App\Livewire;

use App\Models\CurrentMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MigrantWorkerMaritialReport extends Component
{
    public $martitialData = [];
    public $martitialPercentage = [];

    public function mount()
    {

        $this->martitialData = CurrentMigrantWorker::select('maritial_status', DB::raw('COUNT(*) as total_count'))
            ->groupBy('maritial_status')
            ->orderBy('total_count')
            ->pluck('total_count', 'maritial_status')->toArray();
        $totalWorkers = CurrentMigrantWorker::count();

        $this->martitialPercentage = CurrentMigrantWorker::select(
            'maritial_status',
            DB::raw('COUNT(*) * 100.0 / ' . $totalWorkers . ' as percentage')
        )
            ->groupBy('maritial_status')
            ->pluck('percentage', 'maritial_status')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.migrant-worker-maritial-report');
    }
}
