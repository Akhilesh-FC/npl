<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Dashboard(){
        if (Auth::check()) {

            // The user is logged in...
            return view('admin.index');
        }
            return redirect()->back()->with('error','you are not login');
    }
    
    // public function insert(){
    //   for($i=0;$i<1000;$i++){
    //       DB::table('triplechance_bet_logs')->insert([
    //           'game_id'=>$i,
    //           'number'=>$i,
    //           'games_no'=>11111111,
    //           'amount'=>0
    //           ]);
    //   }
    // }

}
