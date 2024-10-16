<?php

namespace App\Http\Controllers;

use App\Models\Lucky16;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Lucky16Controller extends Controller
{
    
    public function bets(){
        $records = DB::table('lucky16_bets')->paginate(10);
        return view('lucky16.bets', compact('records'));
    }
    
    public function results(){
        $records = DB::table('lucky16_results')->paginate(10);
        return view('lucky16.results', compact('records'));
    }
    
    
}

