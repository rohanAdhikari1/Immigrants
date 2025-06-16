<?php

namespace App\Livewire;

use App\Models\ReturnedMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WorkExperienceDuringFEReport extends Component
{

    public $workExpData = [];
    public $workExpPercentage = [];

    public function mount()
    {

        $this->workExpData = ReturnedMigrantWorker::select('work_experience_during_foreign_employment', DB::raw('COUNT(*) as total_count'))
            ->groupBy('work_experience_during_foreign_employment')
            ->orderBy('total_count')
            ->pluck('total_count', 'work_experience_during_foreign_employment')->toArray();
        $totalWorkers = ReturnedMigrantWorker::count();

        $this->workExpPercentage = ReturnedMigrantWorker::select(
            'work_experience_during_foreign_employment',
            DB::raw('COUNT(*) * 100.0 / ' . $totalWorkers . ' as percentage')
        )
            ->groupBy('work_experience_during_foreign_employment')
            ->pluck('percentage', 'work_experience_during_foreign_employment')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.work-experience-during-f-e-report');
    }
}
