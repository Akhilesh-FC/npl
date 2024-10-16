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

class AndarbaharApiController extends Controller
{
   public function andarbahar_Bet(Request $request)
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

    $gamesno = DB::table('andarbahar_bet_logs')->value('period_no');

    foreach ($testData as $item) {
        $user_wallet = DB::table('users')->select('wallet')->where('id', $userid)->first();
        $userwallet = $user_wallet->wallet;

        $gameid = $item['game_id'];
        $amount = $item['amount'];

        if ($userwallet >= $amount) {
            if ($amount >= 1) {
                DB::insert("INSERT INTO `andarbahar_bets`(`user_id`, `game_id`, `amount`, `period_no`, `status`, `created_at`, `updated_at`) VALUES ('$userid','$gameid','$amount','$gamesno','0','$formattedTime','$formattedTime')");
                DB::table('users')->where('id', $userid)->update(['wallet' => DB::raw('wallet - ' . $amount)]);
            }

            $multiplier = DB::table('andarbahar_game_settings')->where('game_id', $gameid)->value('multiplier');
          
            $bet_log = DB::select("SELECT * FROM andarbahar_bet_logs");
            
            foreach ($bet_log as $row) {
                $game_id_array = json_decode($row->game_id);
                
     $num=$row->number;
            $multiply_amt = $amount * $multiplier;
                if ($gameid == $game_id_array) {
                  
                    DB::update("UPDATE `andarbahar_bet_logs` SET `amount`=amount+'$multiply_amt' where number= $num");
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Insufficient balance'], 200);
        }
    }

    return response()->json(['success' => true, 'message' => 'Bet Accepted Successfully!'], 200);
}


 public function andarbahar_BetHistory(Request $request)
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
        $where[] = "andarbahar_bets.user_id = '$userid'";
    }
    $query = "SELECT * FROM `andarbahar_bets`";

    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }

    $query .= " ORDER BY andarbahar_bets.period_no DESC LIMIT $offset,$limit";

    $bet_history = DB::select($query);
     
	//$bet_history=DB::select("SELECT g.games_no AS games_no, g.number AS number, COALESCE(b.game_id, '') AS game_id, COALESCE(b.amount, '') AS amount,COALESCE(b.win_amount, '') AS win_amount FROM green_36_results g LEFT JOIN bets b ON g.games_no = b.games_no AND b.user_id = 1 ORDER BY g.games_no DESC LIMIT 10");
		$result_count=DB::select("SELECT COUNT(`id`) as id FROM `andarbahar_bets`");
		$total_count=$result_count[0]->id;
		 if ($bet_history) {
            $response = [
                'message' => 'data found',
                'success' => true,
				'result_count'=>$total_count,
                'history12' => $bet_history
            ];

            return response()->json($response);
        } else {
            return response()->json(['message' => 'No record found', 'success' => false,
                'data' => []], 200);
        }
	}



 public function andarbahar_BetResult()
{
    
    try {
        
      $spinresult = DB::select("SELECT * FROM `andarbahar_results` ORDER BY `andarbahar_results`.`id` DESC LIMIT 10;");
        if ($spinresult) {
            return response()->json(['success' => true, 'message' => 'Andar Bahar result latest data fatch Successfully..!' , 'result_12' => $spinresult ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Andar Bahar result latest data not found..!']);

    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}

		public function andarbahar_result_store()
{
			$kolkataTime = Carbon::now('Asia/Kolkata');

// Format the date and time as needed
$formattedTime = $kolkataTime->toDateTimeString();
		
			$gamesno=DB::table('andarbahar_bet_logs')->value('period_no');
			
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
				$results=DB::Select("SELECT * FROM `andarbahar_bet_logs` WHERE `number`=$number");
				$game_idd=json_decode($results[0]->game_id);
				//dd($game_idd);
			}elseif($total_amt == 0){
			$result1=DB::select("SELECT *
                   FROM `spin_betlogs`
					WHERE `amount` <= (
						SELECT MIN(`amount`)
						FROM `andarbahar_bet_logs`
					)
					ORDER BY RAND()
					LIMIT 1");
				//dd($result1);
			$number=$result1[0]->number;
				$game_idd=json_decode($result1[0]->game_id);
			
			}elseif($total_amt <= $given_amount){
			$result2=DB::select("SELECT *
						FROM `andarbahar_bet_logs`
						WHERE `amount` <= $given_amount
						ORDER BY RAND()
						LIMIT 1");
			$number=$result2[0]->number;
				$game_idd=json_decode($result2[0]->game_id);
			}else{
			$result3=DB::Select("SELECT * FROM `andarbahar_bet_logs` ORDER BY `amount` ASC LIMIT 1");
				$number=$result3[0]->number;
				$game_idd=json_decode($result3[0]->game_id);
			//dd($number);
			}
			
			$bet_details= DB::select("SELECT * FROM `andarbahar_bets` WHERE `period_no`=$gamesno");
			foreach($bet_details as $item){
				$game_ids=$item->game_id;
				$bet_ids=$item->id;
				$userid=$item->user_id;
				$amounts=$item->amount;
				
			$multiplier=DB::table('andarbahar_game_settings')->where('game_id',$game_ids )->value('multiplier');
				$total_multy_amt=$amounts*$multiplier;
				
           if($game_ids == $game_idd){
		   DB::table('users')->where('id',$userid)->update(['wallet'=>DB::raw("wallet+$total_multy_amt")]);
			   DB::table('andarbahar_bets')->where('id',$bet_ids)->update(['win_amount'=>$total_multy_amt,'status'=>1,'win_number'=>$number]);
		   }else{
		    DB::table('andarbahar_bets')->where('id',$bet_ids)->update(['status'=>2,'win_number'=>$number]);

		   }
				
			}
	
       //dd($number);
		
		$red_black=DB::Select("SELECT * FROM `andarbahar_game_settings` WHERE number=$number && game_id IN(45,46)");
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
			
			 // $index=DB::select("SELECT `card_index`,`color_index` FROM `lucky12_index` WHERE `game_no`=$number;");
			 // $card_index=$index[0]->card_index;
			 // $color_index=$index[0]->color_index;
	     
		
					$store=DB::select("INSERT INTO `andarbahar_results`( `period_no`, `win_number`,`status`, `time`) VALUES ('$gamesno','$number','$status','$formattedTime')");
		
			DB::table('andarbahar_bet_logs')->update(['amount'=>0,'period_no'=>DB::raw("period_no+1")]);
		 $this->amountdistribution($gamesno,$number);
      
}
	
	 private function amountdistribution($gamesno,$number)
    {
        //dd($number);
        //dd($gamesno);
       //dd("hii");
        $amounts = DB::select("SELECT `amount`, `game_id` FROM `andarbahar_bets` WHERE `period_no` = ?", [$gamesno]);
        //dd($amounts);
		 foreach ($amounts as $item) {
        $gameid = $item->game_id;
        //dd($gameid);
        $amount = $item->amount;
        //dd($gameid);
$multiplierResult = DB::select("SELECT `multiplier`,`number` FROM `andarbahar_game_settings` WHERE `game_id` = ?", [$gameid]);
//dd($multiplierResult);
        foreach ($multiplierResult as $winamount) {
            
            $multiple = $winamount->multiplier;
            $total_multiply = $amount * $multiple;
            //dd($total_multiply);
            $win_number=$winamount->number;
            //dd($win_number);
            if(!empty($win_number)){
				
				if($number == $win_number){
				$he	= DB::select("UPDATE andarbahar_bets SET win_amount =$total_multiply,win_number= $number,status=1 WHERE period_no='$gamesno' && game_id=  '$win_number' ");
			     //dd($he);
				}
            }
            
		}
		 }
                $uid = DB::select("SELECT  win_amount,  user_id FROM andarbahar_bets where win_number>=0 && period_no='$gamesno' && game_id=  '$win_number' ");
                //dd($uid);
        foreach ($uid as $row) {
             $amount = $row->win_amount;
            $userid = $row->user_id;
      $useramt= DB::update("UPDATE users SET wallet = wallet + $total_multiply WHERE id = $userid");
        //dd($useramt);
        }
 
          DB::select("UPDATE andarbahar_bets SET status=2 ,win_number= '$number' WHERE period_no='$gamesno' && game_id=  '$gameid' &&  status=0 && win_amount=0");

            
    }






}
