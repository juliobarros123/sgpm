<?php

namespace App\Livewire;

use Livewire\Component;

class Message extends Component
{
    public $message;
    public function render()
    {
        return view('livewire.message');
    }
}
