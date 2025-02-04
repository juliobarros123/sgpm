<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class PaginateComponent extends Component
{

    public $data;
    public function render()
    {
        return view('livewire.admin.paginate-component');
    }
    public function mount($data)
    {
        dd("ola");
        $this->$data = $data;
    }
}
