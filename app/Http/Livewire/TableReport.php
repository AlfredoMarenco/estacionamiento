<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class TableReport extends Component
{
    use WithPagination;
    public $order;

    public function render()
    {
        return view('livewire.table-report',[
            'tickets' => Ticket::where('id','like','%'.$this->order.'%')->paginate(10),
        ]);
    }
}
