<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarWashController extends Controller
{
    public function index()
    {
        return view('carwash.index');
    }

    
}
