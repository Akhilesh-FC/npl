<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\{spinBet,spinResult};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class Lucky12GameApiController extends Controller
{
   public function lucky12Bet(Request $request)
{
    $kolkataTime = Carbon::now('Asia/Kolkata');
    $formattedTime = $kolkataTime->toDateTimeString();

    $validator = Validator::make($request->all(), [
        'user_id' => 'required',
        'bets' => 'required'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
    }

    $testData = $request->bets;
    $userid = $request->user_id;

    $gamesno = DB::table('lucky12_betlogs')->value('period_no');

    foreach ($testData as $item) {
        $user_wallet = DB::table('users')->select('wallet')->where('id', $userid)->first();
        $userwallet = $user_wallet->wallet;

        $gameid = $item['game_id'];
        $amount = $item['amount'];

        if ($userwallet >= $amount) {
            if ($amount >= 1) {
                DB::insert("INSERT INTO `lucky12_bets`(`user_id`, `game_id`, `amount`, `period_no`, `status`, `created_at`, `updated_at`) VALUES ('$userid','$gameid','$amount','$gamesno','0','$formattedTime','$formattedTime')");
                DB::table('users')->where('id', $userid)->update(['wallet' => DB::raw('wallet - ' . $amount)]);
            }

            $multiplier = DB::table('lucky12_game_settings')->where('game_id', $gameid)->value('multiplier');
          
            $bet_log = DB::select("SELECT * FROM lucky12_betlogs");
            
            foreach ($bet_log as $row) {
                $game_id_array = json_decode($row->game_id);
                
     $num=$row->number;
            $multiply_amt = $amount * $multiplier;
                if ($gameid == $game_id_array) {
                  
                    DB::update("UPDATE `lucky12_betlogs` SET `amount`=amount+'$multiply_amt' where number= $num");
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Insufficient balance'], 200);
        }
    }

    return response()->json(['success' => true, 'message' => 'Bet Accepted Successfully!'], 200);
}


//  public function lucky12BetHistory(Request $request)
// {
// 		$validator = Validator::make($request->all(), [
//         'user_id' => 'required',
// 	    'limit' => 'required'
//     ]);

//     $validator->stopOnFirstFailure();

//     if ($validator->fails()) {
//         return response()->json(['success' => false, 'message' => $validator->errors()->first()],200);
//     }
// 		    $userid = $request->user_id;
// 		$limit = $request->limit;
//      $offset = $request->offset ?? 0;
		
// 		$where = [];

//     if (!empty($game_id)) {
//         $where[] = "lucky12_bets.user_id = '$userid'";
//     }
//     $query = "SELECT * FROM `lucky12_bets`";

//     if (!empty($where)) {
//         $query .= " WHERE " . implode(" AND ", $where);
//     }

//     $query .= " ORDER BY lucky12_bets.period_no DESC LIMIT $offset,$limit";

//     $bet_history = DB::select($query);
     
// 	//$bet_history=DB::select("SELECT g.games_no AS games_no, g.number AS number, COALESCE(b.game_id, '') AS game_id, COALESCE(b.amount, '') AS amount,COALESCE(b.win_amount, '') AS win_amount FROM green_36_results g LEFT JOIN bets b ON g.games_no = b.games_no AND b.user_id = 1 ORDER BY g.games_no DESC LIMIT 10");
// 		$result_count=DB::select("SELECT COUNT(`id`) as id FROM `lucky12_bets`");
// 		$total_count=$result_count[0]->id;
// 		 if ($bet_history) {
//             $response = [
//                 'message' => 'data found',
//                 'success' => true,
// 				'result_count'=>$total_count,
//                 'history12' => $bet_history
//             ];

//             return response()->json($response);
//         } else {
//             return response()->json(['message' => 'No record found', 'success' => false,
//                 'data' => []], 200);
//         }
// 	}

public function lucky12BetHistory(Request $request)
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

    // Fetch bet history and calculate sums grouped by period_no
    $bet_history = DB::table('lucky12_bets')
        ->select('period_no')
        ->selectRaw('SUM(amount) as amount, SUM(win_amount) as win_amount')
        ->where('user_id', $userid)
        ->groupBy('period_no')
        ->orderBy('period_no', 'DESC')
        ->offset($offset)
        ->limit($limit)
        ->get();

    // Count the total number of records
    $total_count = DB::table('lucky12_bets')->where('user_id', $userid)->count();

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


 public function lucky12BetResult(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
    }

   
    $user_id = $request->user_id;
    try {
        
        $gamesno=DB::select("SELECT `period_no` FROM `lucky16_betlogs` LIMIT 1;");
         $period=$gamesno[0]->period_no;
          $less_no=$period-1;
        $lastwin_amt=DB::select("SELECT SUM(`win_amount`) as win_amount FROM `lucky12_bets` WHERE `user_id` = $user_id AND `period_no` = $less_no");
        $win_amt = $lastwin_amt[0]->win_amount ?? 0;
        //dd($lastwin_amt);
      $spinresult = DB::select("SELECT * FROM `lucky12_results` ORDER BY `lucky12_results`.`id` DESC LIMIT 10;");
        if ($spinresult) {
            return response()->json(['success' => true, 'message' => 'Spin result latest data fatch Successfully..!' ,'win_amount' => $win_amt, 'result_12' => $spinresult ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Spin result latest data not found..!']);

    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}

		public function lucky12_result_store()
{
			$kolkataTime = Carbon::now('Asia/Kolkata');

// Format the date and time as needed
$formattedTime = $kolkataTime->toDateTimeString();
		
			$gamesno=DB::table('lucky12_betlogs')->value('period_no');
			
			$admin_result=null;
			$given_amount=1000000;
			$result=DB::select("SELECT 
    SUM(`amount`) AS total_amount,
    MIN(`amount`) AS min_amount,
    MAX(`amount`) AS max_amount
FROM `lucky12_betlogs`");
			$total_amt=$result[0]->total_amount;
			$min_amt=$result[0]->min_amount;
			$max_amt=$result[0]->max_amount;
			
			if(!($admin_result == null)){
			$number=$admin_result;
			//dd($number);
				$results=DB::Select("SELECT * FROM `lucky12_betlogs` WHERE `number`=$number");
				$game_idd=json_decode($results[0]->game_id);
				//dd($game_idd);
			}elseif($total_amt == 0){
			$result1=DB::select("SELECT *
                   FROM `lucky12_betlogs`
					WHERE `amount` <= (
						SELECT MIN(`amount`)
						FROM `lucky12_betlogs`
					)
					ORDER BY RAND()
					LIMIT 1");
				//dd($result1);
			$number=$result1[0]->number;
				$game_idd=json_decode($result1[0]->game_id);
			
			}elseif($total_amt <= $given_amount){
			$result2=DB::select("SELECT *
						FROM `lucky12_betlogs`
						WHERE `amount` <= $given_amount
						ORDER BY RAND()
						LIMIT 1");
			$number=$result2[0]->number;
				$game_idd=json_decode($result2[0]->game_id);
			}else{
			$result3=DB::Select("SELECT * FROM `lucky12_betlogs` ORDER BY `amount` ASC LIMIT 1");
				$number=$result3[0]->number;
				$game_idd=json_decode($result3[0]->game_id);
			//dd($number);
			}
			
			$bet_details= DB::select("SELECT * FROM `lucky12_bets` WHERE `period_no`=$gamesno");
			foreach($bet_details as $item){
				$game_ids=$item->game_id;
				$bet_ids=$item->id;
				$userid=$item->user_id;
				$amounts=$item->amount;
				
			$multiplier=DB::table('lucky12_game_settings')->where('game_id',$game_ids )->value('multiplier');
				$total_multy_amt=$amounts*$multiplier;
				
           if($game_ids == $game_idd){
		   DB::table('users')->where('id',$userid)->update(['wallet'=>DB::raw("wallet+$total_multy_amt")]);
			   DB::table('lucky12_bets')->where('id',$bet_ids)->update(['win_amount'=>$total_multy_amt,'status'=>1,'win_number'=>$number]);
		   }else{
		    DB::table('lucky12_bets')->where('id',$bet_ids)->update(['status'=>2,'win_number'=>$number]);

		   }
				
			}
	
       //dd($number);
		
		$red_black=DB::Select("SELECT * FROM `lucky12_game_settings` WHERE number=$number && game_id IN(45,46)");
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
			//dd($number);
			  $index=DB::select("SELECT `card_index`,`color_index` FROM `lucky12_index` WHERE `game_no`=$number;");
			  $card_index=$index[0]->card_index;
			  $color_index=$index[0]->color_index;
	     
		
					$store=DB::select("INSERT INTO `lucky12_results`( `period_no`, `win_number`,`card_index`,`color_index`,`status`, `time`) VALUES ('$gamesno','$number','$card_index','$color_index','$status','$formattedTime')");
		
			DB::table('lucky12_betlogs')->update(['amount'=>0,'period_no'=>DB::raw("period_no+1")]);
		 $this->amountdistribution($gamesno,$number);
      
}
	
	 private function amountdistribution($gamesno,$number)
    {
        //dd($number);
        //dd($gamesno);
       //dd("hii");
        $amounts = DB::select("SELECT `amount`, `game_id` FROM `lucky12_bets` WHERE `period_no` = ?", [$gamesno]);
        //dd($amounts);
		 foreach ($amounts as $item) {
        $gameid = $item->game_id;
        //dd($gameid);
        $amount = $item->amount;
        //dd($amount);
$multiplierResult = DB::select("SELECT `multiplier`,`number` FROM `lucky12_game_settings` WHERE `game_id` = ?", [$gameid]);
//dd($multiplierResult);
        foreach ($multiplierResult as $winamount) {
            
            $multiple = $winamount->multiplier;
            $total_multiply = $amount * $multiple;
            //dd($total_multiply);
            $win_number=$winamount->number;
            //dd($win_number);
            if(!empty($win_number)){
				
				if($number == $win_number){
				$he	= DB::select("UPDATE lucky12_bets SET win_amount =$total_multiply,win_number= $number,status=1 WHERE period_no='$gamesno' && game_id=  '$win_number' ");
			     //dd($he);
				}
            }
            
		}
		 }
                $uid = DB::select("SELECT  win_amount,  user_id FROM lucky12_bets where win_amount>0 && period_no='$gamesno' && game_id=  '$number' ");
                //dd($uid);
        foreach ($uid as $row) {
             $amount = $row->win_amount;
            $userid = $row->user_id;
      //$useramt= DB::update("UPDATE users SET wallet = wallet + $amount WHERE id = $userid");
        //dd($useramt);
        }
 
          DB::select("UPDATE lucky12_bets SET status=2 ,win_number= '$number' WHERE period_no='$gamesno' && game_id=  '$gameid' &&  status=0 && win_amount=0");

            
    }






}