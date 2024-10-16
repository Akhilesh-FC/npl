<?php

namespace App\Http\Controllers;

use App\Models\Timmer36;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Timmer36Controller extends Controller
{
   
    public function bets(){
        $records =DB:: table('timmer_36_bets')->paginate(10);
        return view('timmer36.bets', compact('records'));
    }
    
    public function results(){
        $records = DB::table('timmer_36_results')->paginate(10);
        return view('timmer36.results', compact('records'));
    }
}

