<?php

namespace App\Livewire;

use Livewire\Component;

class Homepage extends Component
{
    public $selectedReport = 'table1';

    public function render()
    {
        return view('livewire.homepage');
    }
}
