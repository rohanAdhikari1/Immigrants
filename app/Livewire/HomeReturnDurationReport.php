<?php

namespace App\Livewire;

use App\Models\ReturnedMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HomeReturnDurationReport extends Component
{

    public $returnDurationData = [];
    public $returnDurationPercentage = [];

    public function mount()
    {

        $this->returnDurationData = ReturnedMigrantWorker::select('years_since_returned', DB::raw('COUNT(*) as total_count'))
            ->groupBy('years_since_returned')
            ->orderBy('total_count')
            ->pluck('total_count', 'years_since_returned')->toArray();
        $total = ReturnedMigrantWorker::count();

        $this->returnDurationPercentage = ReturnedMigrantWorker::select(
            'years_since_returned',
            DB::raw('COUNT(*) * 100.0 / ' . $total . ' as percentage')
        )
            ->groupBy('years_since_returned')
            ->pluck('percentage', 'years_since_returned')
            ->toArray();
    }
    public function render()
    {
        return view('livewire.home-return-duration-report');
    }
}
