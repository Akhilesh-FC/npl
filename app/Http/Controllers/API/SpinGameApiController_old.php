<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{spinBet,spinResult,spinBetlog,User};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class SpinGameApiController extends Controller
{

public function SpinBet(Request $request)
{
    $kolkataTime = Carbon::now('Asia/Kolkata');
    $formattedTime = $kolkataTime->toDateTimeString();

    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'bets' => 'required|array'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
    }

    $testData = $request->bets;
    $user = User::find($request->user_id);
    $gamesno = SpinBetLog::max('period_no');

    foreach ($testData as $item) {
        $gameid = $item['game_id'];
        $amount = $item['amount'];

        if ($user->wallet >= $amount) {
            if ($amount >= 1) {
                SpinBet::create([
                    'user_id' => $user->id,
                    'game_id' => $gameid,
                    'amount' => $amount,
                    'period_no' => $gamesno,
                    'status' => 0,
                    // 'created_at' => $formattedTime,
                    // 'updated_at' => $formattedTime,
                ]);

                $user->decrement('wallet', $amount);

                //$multiplier = SpinGameSetting::where('game_id', $gameid)->value('multiplier');
                $multiplier = DB::table('spin_game_settings')->where('game_id', $gameid)->value('multiplier');

                $betLogs = SpinBetLog::whereJsonContains('game_id', $gameid)->get();

                foreach ($betLogs as $row) {
                    $num = $row->number;
                    $multiply_amt = $amount * $multiplier;

                    $row->increment('amount', $multiply_amt);
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Insufficient balance'], 200);
        }
    }

    return response()->json(['success' => true, 'message' => 'Bet Accepted Successfully!'], 200);
}

public function SpinBetHistory(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer',
        'limit' => 'required|integer',
        'offset' => 'nullable|integer'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
    }

    $userid = $request->user_id;
    $limit = $request->limit;
    $offset = $request->offset ?? 0;

    // Use Eloquent to fetch bet history
    $bet_history = spinBet::where('user_id', $userid)
        ->select('id','period_no','amount','win_amount')
        ->orderBy('period_no', 'DESC')
        ->offset($offset)
        ->limit($limit)
        ->get();

    // Count the total number of records
    $total_count = spinBet::where('user_id', $userid)->count();

    if ($bet_history->isNotEmpty()) {
        return response()->json([
            'message' => 'Data found',
            'success' => true,
            'result_count' => $total_count,
            'data' => $bet_history
        ]);
    } else {
        return response()->json([
            'message' => 'No record found',
            'success' => false,
            'data' => []
        ], 200);
    }
}

public function SpinBetResult(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer|exists:users,id'
    ]);
    $validator->stopOnFirstFailure();
    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
    }

    $user_id = $request->user_id;
    
    try {
        // Get the latest period number
        $latestPeriod = spinBetlog::latest()->value('period_no');
        $previousPeriod = $latestPeriod - 1;

        // Get the total win amount for the user in the previous period
        $winAmount = spinBet::where('user_id', $user_id)
            ->where('period_no', $previousPeriod)
            ->sum('win_amount');

        // Get the last 10 spin results, selecting only necessary fields
        $spinResults = DB::table('spin_results')
            ->select('id', 'period_no', 'win_number','win_index') // specify only needed fields
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Spin result latest data fetched successfully!',
            'win_amount' => $winAmount,
            'data' => $spinResults
        ]);

    } catch (ModelNotFoundException $e) {
        return response()->json(['success' => false, 'message' => 'No data found.'], 200);
    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}

		public function result_store()
{
			$kolkataTime = Carbon::now('Asia/Kolkata');

// Format the date and time as needed
$formattedTime = $kolkataTime->toDateTimeString();
		
			$gamesno=DB::table('spin_betlogs')->value('period_no');
			
			$admin_result=null;
			$given_amount=1000000;
			$result=DB::select("SELECT 
    SUM(`amount`) AS total_amount,
    MIN(`amount`) AS min_amount,
    MAX(`amount`) AS max_amount
FROM `spin_betlogs`");
			$total_amt=$result[0]->total_amount;
			$min_amt=$result[0]->min_amount;
			$max_amt=$result[0]->max_amount;
			
			if(!($admin_result == null)){
			$number=$admin_result;
				$results=DB::Select("SELECT * FROM `spin_betlogs` WHERE `number`=$number");
				$game_idd=json_decode($results[0]->game_id);
				//dd($game_idd);
			}elseif($total_amt == 0){
			$result1=DB::select("SELECT *
                   FROM `spin_betlogs`
					WHERE `amount` <= (
						SELECT MIN(`amount`)
						FROM `spin_betlogs`
					)
					ORDER BY RAND()
					LIMIT 1");
				//dd($result1);
			$number=$result1[0]->number;
				$game_idd=json_decode($result1[0]->game_id);
			
			}elseif($total_amt <= $given_amount){
			$result2=DB::select("SELECT *
						FROM `spin_betlogs`
						WHERE `amount` <= $given_amount
						ORDER BY RAND()
						LIMIT 1");
			$number=$result2[0]->number;
				$game_idd=json_decode($result2[0]->game_id);
			}else{
			$result3=DB::Select("SELECT * FROM `spin_betlogs` ORDER BY `amount` ASC LIMIT 1");
				$number=$result3[0]->number;
				$game_idd=json_decode($result3[0]->game_id);
			//dd($number);
			}
			
			$bet_details= DB::select("SELECT * FROM `spin_bets` WHERE `period_no`=$gamesno");
			foreach($bet_details as $item){
				$game_ids=$item->game_id;
				$bet_ids=$item->id;
				$userid=$item->user_id;
				$amounts=$item->amount;
				
			$multiplier=DB::table('spin_game_settings')->where('game_id',$game_ids )->value('multiplier');
				$total_multy_amt=$amounts*$multiplier;
				
           if($game_ids == $game_idd){
		   DB::table('users')->where('id',$userid)->update(['wallet'=>DB::raw("wallet+$total_multy_amt")]);
			   DB::table('spin_bets')->where('id',$bet_ids)->update(['win_amount'=>$total_multy_amt,'status'=>1,'win_number'=>$number]);
		   }else{
		    DB::table('spin_bets')->where('id',$bet_ids)->update(['status'=>2,'win_number'=>$number]);

		   }
				
			}
	
		$red_black=DB::Select("SELECT * FROM `spin_game_settings` WHERE number=$number && game_id IN(45,46)");
			if($red_black ){
			$game_ids=$red_black[0]->game_id;
        //dd($game_ids);
		if($game_ids == 45){
			$status = 0;
		}else if($game_ids == 46){
			$status = 1;
		}
			}
			else{
			$status = 2;
		}
			//dd($red_black);
			  $index=DB::select("SELECT `index` FROM `spin_index` WHERE `game_no`=$number;");
			  $number_index=$index[0]->index;
	     
		
					$store=DB::select("INSERT INTO `spin_results`( `period_no`, `win_number`,`win_index`,`status`, `time`) VALUES ('$gamesno','$number','$number_index','$status','$formattedTime')");
		
			DB::table('spin_betlogs')->update(['amount'=>0,'period_no'=>DB::raw("period_no+1")]);
		 $this->amountdistribution($gamesno,$number);
      
}
	
	 private function amountdistribution($gamesno,$number)
    {
        //dd($number);
        //dd($gamesno);
       //dd("hii");
        $amounts = DB::select("SELECT `amount`, `game_id` FROM `spin_bets` WHERE `period_no` = ?", [$gamesno]);
        //dd($amounts);
		 foreach ($amounts as $item) {
        $gameid = $item->game_id;
        //dd($gameid);
        $amount = $item->amount;
        //dd($gameid);
$multiplierResult = DB::select("SELECT `multiplier`,`number` FROM `spin_game_settings` WHERE `game_id` = ?", [$gameid]);
//dd($multiplierResult);
        foreach ($multiplierResult as $winamount) {
            
            $multiple = $winamount->multiplier;
            $total_multiply = $amount * $multiple;
            //dd($total_multiply);
            $win_number=$winamount->number;
            ///dd($win_number);
            if(!empty($win_number)){
			//dd($number,$win_number);
			//dd($win_number,$total_multiply,$multiplierResult,$gameid,$number);
				if($number == $win_number){
				$he	= DB::select("UPDATE spin_bet SET win_amount =$total_multiply,win_number= $number,status=1 WHERE period_no='$gamesno' && game_id='$win_number' ");
			    // dd("UPDATE spin_bets SET win_amount =$total_multiply,win_number= $number,status=1 WHERE period_no='$gamesno' && game_id=  '$win_number'");
				}
            }
            
		}
		 }
                $uid = DB::select("SELECT  win_amount,  user_id FROM spin_bets where win_number>=0 && period_no='$gamesno' && game_id='$number' ");
                //dd($uid);
        foreach ($uid as $row) {
             $win_amt = $row->win_amount;
             //dd($win_amt);
            $userid = $row->user_id;
      $useramt= DB::update("UPDATE users SET wallet = wallet + $win_amt WHERE id = $userid");
        //dd($useramt);
        }
 
          DB::select("UPDATE spin_bets SET status=2 ,win_number= '$number' WHERE period_no='$gamesno' && game_id=  '$gameid' &&  status=0 && win_amount=0");

            
    }
    
    

}
