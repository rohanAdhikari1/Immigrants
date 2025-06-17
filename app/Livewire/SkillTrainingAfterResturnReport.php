<?php

namespace App\Livewire;

use App\Models\ReturnedMigrantWorker;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SkillTrainingAfterResturnReport extends Component
{
    public $skillTrainingData = [];
    public $skillTrainingPercentage = [];

    public function mount()
    {
        $this->skillTrainingData = ReturnedMigrantWorker::select('skill_training_after_return_to_nepal', DB::raw('COUNT(*) as total_count'))
            ->groupBy('skill_training_after_return_to_nepal')
            ->orderBy('total_count')
            ->pluck('total_count', 'skill_training_after_return_to_nepal')->toArray();
        $totalWorkers = ReturnedMigrantWorker::count();

        $this->skillTrainingPercentage = ReturnedMigrantWorker::select(
            'skill_training_after_return_to_nepal',
            DB::raw('COUNT(*) * 100.0 / ' . $totalWorkers . ' as percentage')
        )
            ->groupBy('skill_training_after_return_to_nepal')
            ->pluck('percentage', 'skill_training_after_return_to_nepal')
            ->toArray();
    }
    public function render()
    {
        return view('livewire.skill-training-after-resturn-report');
    }
}
