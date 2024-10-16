<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameHistoryController extends Controller
{
    public function gameHistory_index(){
        return view('gameHistory.index');
    }
}
