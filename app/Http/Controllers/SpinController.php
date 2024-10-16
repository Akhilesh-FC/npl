<?php

namespace App\Http\Controllers;

use App\Models\Spin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpinController extends Controller
{
    
    public function adminresults(){
        $records = DB::table('spin_admin_results')->paginate(10);
        return view('spin.adminresults', compact('records'));
    }
    
    public function bets(){
        $records = DB::table('spin_bets')->paginate(10);
        return view('spin.bets', compact('records'));
    }
    
    
    public function results(){
        $records = DB::table('spin_results')->paginate(10);
        return view('spin.results', compact('records'));
    }
}

