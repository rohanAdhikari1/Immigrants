<?php

namespace App\Livewire;

use App\Models\CurrentMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MigrantWorkerEducationReport extends Component
{
    public $educationData = [];
    public $educationPercentage = [];

    public function mount()
    {

        $this->educationData = CurrentMigrantWorker::select('education_detail', DB::raw('COUNT(*) as total_count'))
            ->groupBy('education_detail')
            ->orderBy('total_count')
            ->pluck('total_count', 'education_detail')->toArray();
        $totalWorkers = CurrentMigrantWorker::count();

        $this->educationPercentage = CurrentMigrantWorker::select(
            'education_detail',
            DB::raw('COUNT(*) * 100.0 / ' . $totalWorkers . ' as percentage')
        )
            ->groupBy('education_detail')
            ->pluck('percentage', 'education_detail')
            ->toArray();
    }
    public function render()
    {
        return view('livewire.migrant-worker-education-report');
    }
}
