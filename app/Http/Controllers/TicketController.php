<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function cancel($id)
    {
        $ticket = Ticket::find($id);
        $diffence = Carbon::parse($ticket->datetime_start)->diffInMinutes();
        //return $diffence;
        if($diffence < 6) {
            $ticket->pagado = '2';
            $ticket->datetime_end = Carbon::now();
            $ticket->amount = 0.00;
            $ticket->save();
        } else {
            $ticket->pagado = '3';
            $ticket->datetime_end = Carbon::now();
            $ticket->amount = 20.00;
            $ticket->save();
        }
        return back();

    }
}
