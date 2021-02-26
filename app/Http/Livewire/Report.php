<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class Report extends Component
{
    use WithPagination;
    public $order;

    public function render()
    {
        if ($this->order == '') {
            return view('livewire.report', [
                'tickets' => Ticket::paginate(10),
            ]);
        } else {
            return view('livewire.report', [
                'tickets' => Ticket::where('id', '=', $this->order)->paginate(10),
            ]);
        }
    }
}
