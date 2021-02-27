<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoxCutController extends Controller
{
    public function index(){
        return view('boxcut.index');
    }
}
