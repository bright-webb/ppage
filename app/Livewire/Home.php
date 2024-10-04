<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $title;
    public function render()
    {
        return view('livewire.home');
    }
}
