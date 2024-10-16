<?php

namespace App\Http\Controllers;
use App\Models\AndarBahar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AndarBaharController extends Controller
{

    public function bets(){
        $records = DB::table('ab_bets')->paginate(10);
        return view('andarbahar.bets', compact('records'));
    }
    
    public function betresult()
    {
        $records = DB::table('ab_bet_results')->paginate(10);
        return view('andarbahar.betresult',compact('records'));
    }
    
//     public function andarbahar_index(Request $request,$game_id)
// 	{
// 	   // dd($game_id);
	
// 		// $gamesno=$request->gamesno;
//       $value = $request->session()->has('id');
	
//         if(!empty($value))
//         {
// 			$amounts=DB::select("SELECT bet_logs.*,game_settings.winning_percentage AS parsantage ,game_settings.id AS id FROM `bet_logs` LEFT JOIN game_settings ON bet_logs.game_id=game_settings.id where bet_logs.game_id=$gameid Limit 10");

// 			 return view('andar_bahar.index')->with('amounts', $amounts)->with('game_id', $game_id);
// 		}
//         else
//         {
//           return redirect()->route('login');  
//         }
// 	}
    
}


