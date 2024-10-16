<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstantWinController extends Controller
{
    public function instantWin_index(){
        return view('instantWin.index');
    }
}
