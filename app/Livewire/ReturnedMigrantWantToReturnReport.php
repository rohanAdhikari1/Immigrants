<?php

namespace App\Livewire;

use App\Models\ReturnedMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReturnedMigrantWantToReturnReport extends Component
{

    public $wantToReturnData = [];
    public $wantToReturnPercentage = [];

    public function mount()
    {

        $this->wantToReturnData = ReturnedMigrantWorker::select(
            DB::raw("CASE 
                WHEN intention_to_return_to_foreign_employment = 0 THEN 'छैन' 
                WHEN intention_to_return_to_foreign_employment = 1 THEN 'छ' 
                ELSE 'unknown' END as intention"),
            DB::raw('COUNT(*) as total_count')
        )
            ->groupBy('intention')
            ->orderBy('total_count')
            ->pluck('total_count', 'intention')
            ->toArray();

        $total = ReturnedMigrantWorker::count();

        $this->wantToReturnPercentage = ReturnedMigrantWorker::select(
            DB::raw("CASE 
                WHEN intention_to_return_to_foreign_employment = 0 THEN 'छैन' 
                WHEN intention_to_return_to_foreign_employment = 1 THEN 'छ' 
                ELSE 'unknown' END as intention"),
            DB::raw('COUNT(*) * 100.0 / ' . $total . ' as percentage')
        )
            ->groupBy('intention')
            ->pluck('percentage', 'intention')
            ->toArray();
    }
    public function render()
    {
        return view('livewire.returned-migrant-want-to-return-report');
    }
}
