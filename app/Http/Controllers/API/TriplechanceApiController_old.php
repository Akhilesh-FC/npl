<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class TriplechanceApiController extends Controller
{


// public function triplechance_bet(Request $request)
// {
//     $kolkataTime = Carbon::now('Asia/Kolkata');
//     $formattedTime = $kolkataTime->toDateTimeString();

//     // Validate request
//     $validator = Validator::make($request->all(), [
//         'user_id' => 'required|integer',
//         'bets' => 'required|array', // Ensure bets is an array
//         'bets.*.game_id' => 'required|integer',
//         'bets.*.amount' => 'required|numeric|min:1',
//         'bets.*.wheel_no' => 'required|integer',
//     ]);

//     $validator->stopOnFirstFailure();

//     if ($validator->fails()) {
//         return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
//     }

//     // Decode the bets JSON into an array
//     $testData = $request->bets;
//     $userid = $request->user_id;

//     // Convert bets array back to JSON for insertion
//     $betsJson = json_encode($testData);
    
//     // Get the games number
//     $gamesno = DB::table('triplechance_bet_logs')->value('games_no');

//     foreach ($testData as $item) {
//         $user_wallet = DB::table('users')->select('wallet')->where('id', $userid)->first();
//         $userwallet = $user_wallet->wallet;
//         $amount = $item['amount'];
//         $gameid = $item['game_id']; // Get game_id from the current item

//         if ($userwallet >= $amount) {
//             if ($amount >= 1) {
//                 DB::insert("INSERT INTO `triplechance_bets`(`user_id`, `games_no`, `all_bet`, `status`, `created_at`, `updated_at`) VALUES (?, ?, ?, '0', ?, ?)", [
//                     $userid,
//                     $gamesno,
//                     $betsJson,
//                     $formattedTime,
//                     $formattedTime
//                 ]);
//                 DB::table('users')->where('id', $userid)->update(['wallet' => DB::raw('wallet - ' . $amount)]);
//             }

//             $multiplier = DB::table('triplechance_game_settings')->where('game_id', $gameid)->value('multiplier');
//             $bet_log = DB::select("SELECT * FROM triplechance_bet_logs");

//             foreach ($bet_log as $row) {
//                 $game_id_array = json_decode($row->game_id);

//                 // Ensure $game_id_array is an array
//                 if (!is_array($game_id_array)) {
//                     \Log::error("Invalid game_id_array for row: ", [$row]);
//                     $game_id_array = [];
//                 }

//                 $num = $row->number;
//                 $multiply_amt = $amount * $multiplier;

//                 // Log the comparison
//                 \Log::info("Checking game_id_array: ", $game_id_array);
//                 \Log::info("Current gameid: ", [$gameid]);

//                 // Ensure the types match
//                 if (in_array((int)$gameid, array_map('intval', $game_id_array))) {
//                     // Update the amount and log affected rows
//                     $affectedRows = DB::update("UPDATE `triplechance_bet_logs` SET `amount` = amount + ? WHERE number = ?", [$multiply_amt, $num]);
//                     if ($affectedRows === 0) {
//                         \Log::info("No rows updated for number: $num with game_id: $gameid");
//                     } else {
//                         \Log::info("Updated bet_logs with amount: $multiply_amt for number: $num");
//                     }
//                 }
//             }
//         } else {
//             return response()->json([
//                 'msg' => "Insufficient balance",
//                 'success' => false,
//             ]);
//         }
//     }

//     return response()->json([
//         'success' => true,
//         'message' => 'Bet Accepted Successfully!',
//     ]);
// }

 public function triplechance_bet(Request $request)
{
    $kolkataTime = Carbon::now('Asia/Kolkata');
    $formattedTime = $kolkataTime->toDateTimeString();

    $validator = Validator::make($request->all(), [
        'user_id' => 'required',
        'bets' => 'required'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['status' => 400, 'message' => $validator->errors()->first()], 200);
    }

    $testData = $request->bets;
    $userid = $request->user_id;

    $gamesno = DB::table('triplechance_bet_logs')->value('games_no');

    foreach ($testData as $item) {
        $user_wallet = DB::table('users')->select('wallet')->where('id', $userid)->first();
        $userwallet = $user_wallet->wallet;

        $gameid = $item['game_id'];
        $amount = $item['amount'];
        $wheel_no = $item['wheel_no'];

        if ($userwallet >= $amount) {
            if ($amount >= 1) {
                DB::insert("INSERT INTO `triplechance_bets`(`user_id`, `game_id`, `amount`,`wheel_no`, `games_no`, `status`, `created_at`, `updated_at`) VALUES ('$userid','$gameid','$amount','$wheel_no','$gamesno','0','$formattedTime','$formattedTime')");
                DB::table('users')->where('id', $userid)->update(['wallet' => DB::raw('wallet - ' . $amount)]);
            }

            $multiplier = DB::table('triplechance_game_settings')->where('game_id', $gameid)->value('multiplier');

            $bet_log = DB::select("SELECT * FROM triplechance_bet_logs");
             foreach ($bet_log as $row) {
                $game_id_array = json_decode($row->game_id);
                
     $num=$row->number;
            $multiply_amt = $amount * $multiplier;
                if ($gameid == $game_id_array) {
                  
                    DB::update("UPDATE `triplechance_bet_logs` SET `amount`=amount+'$multiply_amt' where number= $num");
                }
            }
        } else {
            return response()->json(['status' => 400, 'message' => 'Insufficient balance'], 200);
        }
    }

    return response()->json(['status' => 200, 'message' => 'Bet Accepted Successfully!'], 200);
}

 public function triplechanceBetHistory(Request $request)
{
		$validator = Validator::make($request->all(), [
        'user_id' => 'required',
	    'limit' => 'required'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['status' => 400, 'message' => $validator->errors()->first()],200);
    }
		    $userid = $request->user_id;
		$limit = $request->limit;
     $offset = $request->offset ?? 0;
		
		$where = [];

    if (!empty($game_id)) {
        $where[] = "triplechance_bets.user_id = '$userid'";
    }
    $query = "SELECT * FROM `triplechance_bets`";

    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }

    $query .= " ORDER BY triplechance_bets.games_no DESC LIMIT $offset,$limit";

    $bet_history = DB::select($query);
     
	//$bet_history=DB::select("SELECT g.games_no AS games_no, g.number AS number, COALESCE(b.game_id, '') AS game_id, COALESCE(b.amount, '') AS amount,COALESCE(b.win_amount, '') AS win_amount FROM green_36_results g LEFT JOIN bets b ON g.games_no = b.games_no AND b.user_id = 1 ORDER BY g.games_no DESC LIMIT 10");
		$result_count=DB::select("SELECT COUNT(`id`) as id FROM `triplechance_bets`");
		$total_count=$result_count[0]->id;
		 if ($bet_history) {
            $response = [
                'message' => 'data found',
                'success' => true,
				'result_count'=>$total_count,
                'history_triplechance' => $bet_history
            ];

            return response()->json($response);
        } else {
            return response()->json(['message' => 'No record found', 'success' => false,
                'data' => []], 200);
        }
	}

public function triplechanceBetResult(Request $request)
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
        $lastwin_amt=DB::select("SELECT SUM(`win_amount`) as win_amount FROM `triplechance_bets` WHERE `user_id` = $user_id AND `games_no` = (SELECT MAX(`games_no`) FROM `triplechance_bets` WHERE `user_id` = $user_id)");
        $win_amt = $lastwin_amt[0]->win_amount ?? 0;
        //dd($lastwin_amt);
      $spinresult = DB::select("SELECT * FROM `triplechance_results` ORDER BY `triplechance_results`.`id` DESC LIMIT 10;");
        if ($spinresult) {
            return response()->json(['success' => true, 'message' => 'TripleChance result latest data fatch Successfully..!' ,'win_amount' => $win_amt, 'result_triple_chance' => $spinresult ]);
        }
        
        return response()->json(['success' => false, 'message' => 'TripleChance result latest data not found..!']);

    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}

// public function tc_result_store()
// {
//      $games_no=DB::table('triplechance_bet_logs')->value('games_no');
//     $sum_amount = DB::table('triplechance_bets')->where('games_no',$games_no)->sum('amount');
//     $winning_amt=$sum_amount *0.70;
//     $rand_game_id = DB::table('triplechance_bet_logs')
//     ->where('amount', '<=', $winning_amt)
//     ->inRandomOrder()
//     ->value('game_id');
//     $x = $rand_game_id;
//     $digit_count = strlen(strval($x));
//      $arr = str_split(strval($x));
//      if($digit_count==1){
//          $third_wheel_number = $arr[0];
//          $second_wheel_number = "0";
//          $first_wheel_number = "0";
//      }elseif($digit_count==2){
//          $third_wheel_number = $arr[1];
//          $second_wheel_number = $arr[0];
//          $first_wheel_number = "0";
//      }elseif($digit_count==3){
//          $third_wheel_number = $arr[2];
//          $second_wheel_number = $arr[1];
//          $first_wheel_number = $arr[0];
//      }
//       $index = [
//           '0'=>'2',
//           '1'=>'8',
//           '2'=>'3',
//           '3'=>'7',
//           '4'=>'4',
//           '5'=>'6',
//           '6'=>'0',
//           '7'=>'5',
//           '8'=>'1',
//           '9'=>'9',
//           ];
//      $third_index =$index[$third_wheel_number];
//      $second_index =$index[$second_wheel_number];
//      $first_index =$index[$first_wheel_number];
     
//      //dd($third_wheel_number,$third_index,$second_wheel_number,$second_index,$first_wheel_number,$first_index);
     
//         //   DB::select("INSERT INTO `triplechance_results`(`games_no`, `wheel1_index`, `wheel1_result`, `wheel2_index`, `wheel2_result`, `wheel3_index`, `wheel3_result`, `status`) VALUES ('$games_no','$first_index','$first_wheel_number','$second_index','$second_wheel_number','$third_index','$third_wheel_number','0')");
//          DB::select("INSERT INTO `triplechance_results`(`games_no`, `wheel1_index`, `wheel1_result`, `wheel2_index`, `wheel2_result`, `wheel3_index`, `wheel3_result`, `status`) VALUES ('$games_no','$first_wheel_number','$first_index','$second_wheel_number','$second_index','$third_wheel_number','$third_index','0')");

//           DB::table('triplechance_bet_logs')->update(['amount'=>0,'games_no'=>DB::raw("games_no+1")]);
//           $bet_details = DB::table('triplechance_bets')
//     ->where('games_no', $games_no)
//     ->where('game_id', $first_wheel_number)
//     ->where('wheel_no', 1)
//     ->get();
// dd($bet_details);
// if (!$bet_details->isEmpty()) {
//     foreach ($bet_details as $item) {
//         $userid = $item->user_id;
//         $amounts = $item->amount * 9;
        
//         // Update the user's wallet
//         DB::table('users')->where('id', $userid)->update([
//             'wallet' => DB::raw("wallet + $amounts")
//         ]);

//         // Update bet details
//         DB::table('triplechance_bets')
//             ->where('status', 0)
//             ->where('wheel_no', 1)
//             ->where('game_id', $first_wheel_number)
//             ->where('games_no', $games_no)
//             ->update([
//                 'win_amount' => $amounts,
//                 'status' => 1,
//                 'win_number' => $first_wheel_number
//             ]);
//     }
// } 

// $bet_details2 = DB::table('triplechance_bets')
//     ->where('games_no', $games_no)
//     ->whereIn('game_id', [$first_wheel_number, $second_wheel_number])
//     ->where('wheel_no', 2)
//     ->get();

// if (!$bet_details2->isEmpty()) {
//     foreach ($bet_details2 as $item) {
//         $userid = $item->user_id;
//         $amounts = $item->amount * 90;

//         // Update the user's wallet
//         DB::table('users')->where('id', $userid)->update([
//             'wallet' => DB::raw("wallet + $amounts")
//         ]);

//         // Update bet details
//         DB::table('triplechance_bets')
//             ->where('status', 0)
//             ->where('wheel_no', 2)
//             ->whereIn('game_id', [$first_wheel_number, $second_wheel_number])
//             ->where('games_no', $games_no)
//             ->update([
//                 'win_amount' => $amounts,
//                 'status' => 1,
//                 'win_number' => "$first_wheel_number,$second_wheel_number"
//             ]);
//     }
// } 

// $bet_details3 = DB::table('triplechance_bets')
//     ->where('games_no', $games_no)
//     ->whereIn('game_id', [$first_wheel_number, $second_wheel_number, $third_wheel_number])
//     ->where('wheel_no', 3)
//     ->get();

// if (!$bet_details3->isEmpty()) {
//     foreach ($bet_details3 as $item) {
//         $userid = $item->user_id;
//         $amounts = $item->amount * 900;

//         // Update the user's wallet
//         DB::table('users')->where('id', $userid)->update([
//             'wallet' => DB::raw("wallet + $amounts")
//         ]);

//         // Update bet details
//         DB::table('triplechance_bets')
//             ->where('status', 0)
//             ->where('wheel_no', 3)
//             ->whereIn('game_id', [$first_wheel_number, $second_wheel_number, $third_wheel_number])
//             ->where('games_no', $games_no)
//             ->update([
//                 'win_amount' => $amounts,
//                 'status' => 1,
//                 'win_number' => "$first_wheel_number,$second_wheel_number,$third_wheel_number"
//             ]);
//     }
// } 

     
     
//     DB::table('triplechance_bets')
//         ->where('status', 0)
//         ->where('games_no', $games_no)
//         ->update([
//             'status' => 2,
//             'win_number' => $first_wheel_number
//         ]);

     
     	
//      	$this->amountdistribution($games_no,$rand_game_id);
     	
     	
      
   
    
// }

public function tc_result_store()
{
    $games_no = DB::table('triplechance_bet_logs')->value('games_no');
    $sum_amount = DB::table('triplechance_bets')->where('games_no', $games_no)->sum('amount');
    $winning_amt = $sum_amount * 0.70;
    
    // Get random game ID
    $rand_game_id = DB::table('triplechance_bet_logs')
        ->where('amount', '<=', $winning_amt)
        ->inRandomOrder()
        ->value('game_id');

    // Split random game ID into digits
    $x = $rand_game_id;
    $arr = str_split(str_pad($x, 3, '0', STR_PAD_LEFT)); // Pad with leading zeros if needed
    
    // Assign wheel numbers
    $first_wheel_number = $arr[0];
    $second_wheel_number = $arr[1];
    $third_wheel_number = $arr[2];

    // Index mapping for wheel numbers
    $index = [
        '0' => '2', '1' => '8', '2' => '3', '3' => '7', '4' => '4',
        '5' => '6', '6' => '0', '7' => '5', '8' => '1', '9' => '9'
    ];
    
    $first_index = $index[$first_wheel_number];
    $second_index = $index[$second_wheel_number];
    $third_index = $index[$third_wheel_number];

    // Insert the result into triplechance_results
    DB::table('triplechance_results')->insert([
        'games_no' => $games_no,
        'wheel1_index' => $first_index,
        'wheel1_result' => $first_wheel_number,
        'wheel2_index' => $second_index,
        'wheel2_result' => $second_wheel_number,
        'wheel3_index' => $third_index,
        'wheel3_result' => $third_wheel_number,
        'status' => 0
    ]);

    // Update triplechance_bet_logs
    DB::table('triplechance_bet_logs')->update([
        'amount' => 0,
        'games_no' => DB::raw('games_no + 1')
    ]);

    // Update bets for first wheel
    $this->update_bets($games_no, 1, $first_wheel_number, 9);
    
    // Update bets for second wheel
    $this->update_bets($games_no, 2, [$first_wheel_number, $second_wheel_number], 90);
    
    // Update bets for third wheel
    $this->update_bets($games_no, 3, [$first_wheel_number, $second_wheel_number, $third_wheel_number], 900);
    
    // Update remaining bets to 'lost'
    DB::table('triplechance_bets')
        ->where('status', 0)
        ->where('games_no', $games_no)
        ->update(['status' => 2, 'win_number' => $first_wheel_number]);

    // Call amount distribution method
    $this->amountdistribution($games_no, $rand_game_id);
}

/**
 * Update bets for a given wheel.
 */
private function update_bets($games_no, $wheel_no, $game_ids, $multiplier)
{
    $bet_details = DB::table('triplechance_bets')
        ->where('games_no', $games_no)
        ->where('wheel_no', $wheel_no)
        ->whereIn('game_id', (array) $game_ids)
        ->get();

    if (!$bet_details->isEmpty()) {
        foreach ($bet_details as $item) {
            $userid = $item->user_id;
            $amounts = $item->amount * $multiplier;

            // Update the user's wallet
            DB::table('users')->where('id', $userid)->update([
                'wallet' => DB::raw("wallet + $amounts")
            ]);

            // Update bet details
            DB::table('triplechance_bets')
                ->where('id', $item->id)
                ->update([
                    'win_amount' => $amounts,
                    'status' => 1,
                    'win_number' => implode(',', (array) $game_ids)
                ]);
        }
    }
}



     private function amountdistribution($games_no,$rand_game_id)
    {
        
        $amounts = DB::select("SELECT `amount`, `game_id` FROM `triplechance_bets` WHERE `games_no` = ?", [$games_no]);
        
		 foreach ($amounts as $item) {
        $gameid = $item->game_id;
        //dd($gameid);
        $amount = $item->amount;
        //dd($gameid);
$multiplierResult = DB::select("SELECT `multiplier`,`number` FROM `triplechance_game_settings` WHERE `game_id` = ?", [$gameid]);
//dd($multiplierResult);
        foreach ($multiplierResult as $winamount) {
            
            $multiple = $winamount->multiplier;
            $total_multiply = $amount * $multiple;
            //dd($total_multiply);
            $win_number=$winamount->number;
            //dd($win_number);
            if(!empty($win_number)){
				
				if($number == $win_number){
				$he	= DB::select("UPDATE triplechance_bets SET win_amount =$total_multiply,win_number= $rand_game_id,status=1 WHERE period_no='$games_no' && game_id=  '$win_number' ");
			     //dd($he);
				}
            }
            
		}
		 }
                $uid = DB::select("SELECT  win_amount,  user_id FROM triplechance_bets where win_number>=0 && period_no='$games_no' && game_id=  '$win_number' ");
                //dd($uid);
        foreach ($uid as $row) {
             $amount = $row->win_amount;
            $userid = $row->user_id;
      $useramt= DB::update("UPDATE users SET wallet = wallet + $total_multiply WHERE id = $userid");
        //dd($useramt);
        }
 
          DB::select("UPDATE triplechance_bets SET status=2 ,win_number= '$rand_game_id' WHERE period_no='$games_no' && game_id=  '$gameid' &&  status=0 && win_amount=0");

            
    }
    
    
    
    
    
    
    
}