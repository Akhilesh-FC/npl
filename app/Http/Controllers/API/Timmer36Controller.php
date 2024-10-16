<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;




class Timmer36Controller extends Controller
{	

	
		public function timmer36_result_store()
{
			$kolkataTime = Carbon::now('Asia/Kolkata');

// Format the date and time as needed
$formattedTime = $kolkataTime->toDateTimeString();
			
			$gamesno=DB::table('timmer_36_bet_logs')->value('games_no');
			
			$admin_result=null;
			$given_amount=1000000;
			$result=DB::select("SELECT 
    SUM(`amount`) AS total_amount,
    MIN(`amount`) AS min_amount,
    MAX(`amount`) AS max_amount
FROM `timmer_36_bet_logs`");
			$total_amt=$result[0]->total_amount;
			$min_amt=$result[0]->min_amount;
			$max_amt=$result[0]->max_amount;
			
			if(!($admin_result == null)){
			$number=$admin_result;
				
				$results=DB::Select("SELECT * FROM `timmer_36_bet_logs` WHERE `number`=$number");
				$game_idd=json_decode($results[0]->game_id);
				//dd($game_idd);
			}elseif($total_amt == 0){
			$result1=DB::select("SELECT *
                   FROM `timmer_36_bet_logs`
					WHERE `amount` <= (
						SELECT MIN(`amount`)
						FROM `timmer_36_bet_logs`
					)
					ORDER BY RAND()
					LIMIT 1");
				//dd($result1);
			$number=$result1[0]->number;
				$game_idd=json_decode($result1[0]->game_id);
			
			}elseif($total_amt <= $given_amount){
			$result2=DB::select("SELECT *
						FROM `timmer_36_bet_logs`
						WHERE `amount` <= $given_amount
						ORDER BY RAND()
						LIMIT 1");
			$number=$result2[0]->number;
				$game_idd=json_decode($result2[0]->game_id);
			}else{
			$result3=DB::Select("SELECT * FROM `timmer_36_bet_logs` ORDER BY `amount` ASC LIMIT 1");
				$number=$result3[0]->number;
				$game_idd=json_decode($result3[0]->game_id);
			//dd($number);
			}
			
			$bet_details= DB::select("SELECT * FROM `timmer_36_bets` WHERE `games_no`=$gamesno");
			foreach($bet_details as $item){
				$game_ids=$item->game_id;
				$bet_ids=$item->id;
				$userid=$item->user_id;
				$amounts=$item->amount;
				
			$multiplier=DB::table('timmer_36_game_settings')->where('game_id',$game_ids )->value('multiplier');
				$total_multy_amt=$amounts*$multiplier;
				
           if(in_array($game_ids,$game_idd)){
		   DB::table('users')->where('id',$userid)->update(['wallet'=>DB::raw("wallet+$total_multy_amt")]);
			   DB::table('timmer_36_bets')->where('id',$bet_ids)->update(['win_amount'=>$total_multy_amt,'status'=>1,'win_number'=>$number]);
		   }else{
		    DB::table('timmer_36_bets')->where('id',$bet_ids)->update(['status'=>2,'win_number'=>$number]);

		   }
				
			}
	
		$red_black=DB::Select("SELECT * FROM `timmer_36_game_settings` WHERE number=$number && game_id IN(45,46)");
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
	     
		
					$store=DB::select("INSERT INTO `timmer_36_results`( `games_no`, `number`,`status`, `time`) VALUES ('$gamesno','$number','$status','$formattedTime')");
		
			DB::table('timmer_36_bet_logs')->update(['amount'=>0,'games_no'=>DB::raw("games_no+1")]);
		 //$this->amount_distributation($gamesno);
      
}
	
	 
	public function timmer36_result_index()
	{
	
	$last_result=DB::select("SELECT * FROM `timmer_36_results` ORDER BY `id` DESC");
		$value=$last_result[0]->number;
		$games_no=$last_result[0]->games_no;
		$number_index=DB::select("SELECT `index` FROM `timmer_36_wheel_index` WHERE value=$value");
		$index=$number_index[0]->index;
		
		 if ($last_result) {
            $response = [
                'message' => 'data found',
                'success' => true,
                'value' => $value,
				'games_no'=>$games_no,
				'index'=>$index
            ];

            return response()->json($response);
        } else {
            return response()->json(['message' => 'No record found', 'success' => false,
                'data' => []], 200);
        }
	}
	
	public function timmer36_bet_history(Request $request)
	{
		$validator = Validator::make($request->all(), [
        'user_id' => 'required',
	    'limit' => 'required'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()],200);
    }
		    $userid = $request->user_id;
		$limit = $request->limit;
     $offset = $request->offset ?? 0;
		
		$where = [];

    if (!empty($game_id)) {
        $where[] = "timmer_36_bets.user_id = '$userid'";
    }
    $query = "SELECT g.games_no AS games_no, g.number AS number, COALESCE(b.game_id, '') AS game_id, COALESCE(b.amount, '') AS amount ,COALESCE(b.win_amount, '') AS win_amount FROM timmer_36_results g LEFT JOIN timmer_36_bets b ON g.games_no = b.games_no ";

    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }

    $query .= " ORDER BY g.games_no DESC LIMIT $offset,$limit";

    $bet_history = DB::select($query);
     
	//$bet_history=DB::select("SELECT g.games_no AS games_no, g.number AS number, COALESCE(b.game_id, '') AS game_id, COALESCE(b.amount, '') AS amount,COALESCE(b.win_amount, '') AS win_amount FROM green_36_results g LEFT JOIN bets b ON g.games_no = b.games_no AND b.user_id = 1 ORDER BY g.games_no DESC LIMIT 10");
		$result_count=DB::select("SELECT COUNT(`id`) as id FROM `timmer_36_results`");
		$total_count=$result_count[0]->id;
		 if ($bet_history) {
            $response = [
                'message' => 'data found',
               'success' => true,
				'result_count'=>$total_count,
                'data' => $bet_history
            ];

            return response()->json($response);
        } else {
            return response()->json(['message' => 'No record found', 'success' => false,
                'data' => []], 200);
        }
	}
	
	
	public function timmer36_last13_result()
	{
	
		
// 	$last_result=DB::select("SELECT * FROM timmer_36_results ORDER BY id DESC limit 13");
$last_result = DB::select("SELECT * FROM timmer_36_results ORDER BY id DESC LIMIT 12 OFFSET 1");

		
		
		 if ($last_result) {
            $response = [
                'message' => 'data found',
                'success' => true,
                'data' => $last_result
            ];

            return response()->json($response);
        } else {
            return response()->json(['message' => 'No record found', 'success' => false,
                'data' => []], 200);
        }
	}
	
	
	
	public function timmer36_bet(Request $request)
{
		$kolkataTime = Carbon::now('Asia/Kolkata');

// Format the date and time as needed
$formattedTime = $kolkataTime->toDateTimeString();
	//dd($formattedTime);	
    $validator = Validator::make($request->all(), [
        'user_id' => 'required',
        'bets'=>'required'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()],200);
    }
    
     $testData = $request->bets;
    $userid = $request->user_id;
      
    $gamesno=DB::table('timmer_36_bet_logs')->value('games_no');
    //$gamesno=$gamesrno[0]->games_no;
		//$gamesno = !empty($game_no) ? $game_no[0]->gamesno + 1 : 1;
 
    foreach ($testData as $item) {
        $user_wallet = DB::table('users')->select('wallet')->where('id', $userid)->first();
            $userwallet = $user_wallet->wallet;
   
        $gameid = $item['game_id'];
        $amount = $item['amount'];
        if($userwallet >= $amount){
      if ($amount>=1) {
        DB::insert("INSERT INTO `timmer_36_bets`(`user_id`, `game_id`, `amount`, `games_no`, `status`, `created_at`, `updated_at`) VALUES ('$userid','$gameid','$amount','$gamesno','0','$formattedTime','$formattedTime')");
            DB::table('users')->where('id', $userid)->update(['wallet' => DB::raw('wallet - ' . $amount)]);
      }
			$multiplier=DB::table('timmer_36_game_settings')->where('game_id',$gameid )->value('multiplier');
			
			$bet_log = DB::select("SELECT * FROM timmer_36_bet_logs ");
             foreach($bet_log as $row){
             $game_id_array = json_decode($row->game_id);
             $num=$row->number;
            $multiply_amt = $amount * $multiplier;
				if(in_array($gameid, $game_id_array)) {
                     $bet_amt= DB::update("UPDATE `timmer_36_bet_logs` SET `amount`=amount+'$multiply_amt' where number= $num");
                    }
             }
			
			
      }
      
      else {
                $response['msg'] = "Insufficient balance";
                $response['success'] = "false";
                return response()->json($response);
            }

    }

     return response()->json([
        'success' => true,
        'message' => 'Bet Accepted Successfuly!',
    ]);   
    
}

	public function timmer36_win_amount(Request $request)
      {
		  $validator = Validator::make($request->all(), [
        'user_id' => 'required|numeric'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        $response = [
            'success' => false,
            'message' => $validator->errors()->first()
        ];
        return response()->json($response, 200);
    }

    $userid = $request->user_id;
 
		  $bet_amount=DB::select("SELECT g.games_no AS games_no, g.number AS number, CASE WHEN SUM(COALESCE(b.amount, 0)) = 0 THEN 0 ELSE SUM(b.amount) END AS amount, CASE WHEN SUM(COALESCE(b.win_amount, 0)) = 0 THEN 0 ELSE SUM(b.win_amount) END AS total_win_amount FROM timmer_36_results g LEFT JOIN timmer_36_bets b ON g.games_no = b.games_no AND b.user_id =$userid  GROUP BY g.games_no, g.number ORDER BY g.games_no DESC LIMIT 1");
	
		$total_win_amount=$bet_amount[0]->total_win_amount;
		$amount=$bet_amount[0]->amount;
		  
        if ($bet_amount) {
            $response = [
                'message' => 'Successfully',
                'success' => true,
                'win_amount' => $total_win_amount,
				'bet_amount' => $amount
            ];

            return response()->json($response);
        } else {
            return response()->json(['message' => 'No record found', 'success' => false,
                'data' => []], );
        }
    }
	



}
