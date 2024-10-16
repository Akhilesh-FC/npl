<?php

namespace App\Http\Controllers;

use App\Models\Lucky12;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Lucky12Controller extends Controller
{
    
    public function bets(){
        $records = DB::table('lucky12_bets')->paginate(10);
        return view('lucky12.bets', compact('records'));
    }

    
    public function results(){
        $records = DB::table('lucky12_results')->paginate(10);
        return view('lucky12.results', compact('records'));
    }
   
}

