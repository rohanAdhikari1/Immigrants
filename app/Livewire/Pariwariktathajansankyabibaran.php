<?php

namespace App\Livewire;

use Livewire\Component;

class Pariwariktathajansankyabibaran extends Component
{
    public $wardWiseDataMale = [];
    public $wardWiseDataFemale = [];
    public $ghardhuriData = [];
    public $ghardhuriDataMale = [];
    public $ghardhuriDataFemale = [];

    public function mount()
    {
        $this->wardWiseDataMale = [
            '1' => 100,
            '2' => 200,
            '3' => 150,
            '4' => 250,
        ];

        $this->wardWiseDataFemale = [
            '1' => 120,
            '2' => 220,
            '3' => 170,
            '4' => 270,
        ];

        $this->ghardhuriDataMale = [
            '1' => 100,
            '2' => 200,
            '3' => 150,
            '4' => 250,
        ];

        $this->ghardhuriDataFemale = [
            '1' => 120,
            '2' => 220,
            '3' => 170,
            '4' => 270,
        ];

        $this->ghardhuriData = [50, 75];
    }

    public function render()
    {
        return view('livewire.pariwariktathajansankyabibaran');
    }
}
