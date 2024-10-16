<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameSummaryController extends Controller
{
    public function gameSummary_index(){
        return view('gameSummary.index');
    }
}
