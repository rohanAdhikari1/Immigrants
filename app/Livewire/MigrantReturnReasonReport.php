<?php

namespace App\Livewire;

use App\Models\ReturnedMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MigrantReturnReasonReport extends Component
{
    public $returnReasonData = [];
    public $returnReasonPercentage = [];

    public function mount()
    {

        $this->returnReasonData = ReturnedMigrantWorker::select('reason_for_returning_from_foreign_employment', DB::raw('COUNT(*) as total_count'))
            ->groupBy('reason_for_returning_from_foreign_employment')
            ->orderBy('total_count')
            ->pluck('total_count', 'reason_for_returning_from_foreign_employment')->toArray();
        $totalWorkers = ReturnedMigrantWorker::count();

        $this->returnReasonPercentage = ReturnedMigrantWorker::select(
            'reason_for_returning_from_foreign_employment',
            DB::raw('COUNT(*) * 100.0 / ' . $totalWorkers . ' as percentage')
        )
            ->groupBy('reason_for_returning_from_foreign_employment')
            ->pluck('percentage', 'reason_for_returning_from_foreign_employment')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.migrant-return-reason-report');
    }
}
