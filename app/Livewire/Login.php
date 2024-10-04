<?php

namespace App\Livewire;

use Livewire\Component;

class Login extends Component
{
    public $email;
    public function render()
    {
        return view('livewire.login')->with('email', value: $this->email);
    }
}
