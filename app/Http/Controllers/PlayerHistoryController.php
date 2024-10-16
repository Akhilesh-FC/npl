<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerHistoryController extends Controller
{
    public function playerHistory_index(){
        return view('playerHistory.index');
    }
}
