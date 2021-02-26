<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FormReportes extends Component
{

    public $order = "";

    public function render()
    {
        return view('livewire.form-reportes');
    }

    public function getReport(){
        $this->emit('getReport');
    }
}
