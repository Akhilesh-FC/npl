<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;



class AndarBaharApiController extends Controller
{
    
    //// Bet ////
    
public function bets(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required',
        'bets'=>'required'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()],200);
    }
    
    $datetime=date('Y-m-d H:i:s');
    
     $testData = $request->bets;
    $userid = $request->user_id;
    $gameid = 13;
  // $gameno = $request->game_no;
 
  $orderid = date('YmdHis') . rand(11111, 99999);
    
    $gamesrno=DB::select("SELECT period_no FROM `ab_bet_logs` WHERE `game_id`=$gameid  LIMIT 1");
    $gamesno=$gamesrno[0]->period_no;
 
   //dd($gamesno);
    
    foreach ($testData as $item) {
        $user_wallet = DB::table('users')->select('wallet')->where('id', $userid)->first();
            $userwallet = $user_wallet->wallet;
   
        $number = $item['number'];
        $amount = $item['amount'];
        if($userwallet >= $amount){
      if ($amount>=1) {
        DB::insert("INSERT INTO `ab_bets`(`amount`,`trade_amount`, `number`, `period_no`, `game_id`, `user_id`, `status`,`order_id`,`created_at`,`updated_at`) 
            VALUES ('$amount','$amount', '$number', '$gamesno', '$gameid', '$userid', '0','$orderid','$datetime','$datetime')");

        $data1 = DB::table('virtual_games')->where('game_id',$gameid)->where('number',$number)->first();
        $multiplier = $data1->multiplier;
        $num = $data1->actual_number;
       $multiply_amt = $multiplier*$amount;
       $bet_amt = DB::table('ab_bet_logs')->where('game_id',$gameid)->where('number',$num)->update([
           'amount'=>DB::raw("amount + $multiply_amt")
           ]);
       DB::table('users')->where('id', $userid)->update(['wallet' => DB::raw("wallet - $amount")]);
      }
      }
      else {
            return response()->json(['success' => false, 'message' => 'Insufficient balance'], 200);
        }
    }

    return response()->json(['success' => true, 'message' => 'Bet Accepted Successfully!'], 200);
}



////// Result Api ////
    public function results(Request $request)
  {
     $validator = Validator::make($request->all(), [
        'user_id' => 'required'
    ]);

    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
    }

   
    $user_id = $request->user_id;
    //dd($user_id);
    try {
        
        $gamesno=DB::select("SELECT `period_no` FROM `ab_bet_logs` LIMIT 1;");
         $period=$gamesno[0]->period_no;
         $less_no=$period-1;
        
          //dd("SELECT SUM(`win_amount`) as win_amount FROM `lucky12_bets` WHERE `user_id` = $user_id AND `period_no` = $less_no");
          $lastwin_amt=DB::select("SELECT SUM(`win_amount`) as win_amount FROM `ab_bets` WHERE `user_id` = $user_id AND `period_no` = $less_no");
        $win_amt = $lastwin_amt[0]->win_amount ?? 0;
      //$spinresult = DB::select("SELECT * FROM `ab_bet_results` ORDER BY `ab_bet_results`.`id` DESC LIMIT 10;");
      //$andarbahar_card = DB::table('ab_bet_results')->select('random_card', 'andar_bahar_card', 'period_no')->orderBy('id', 'desc')->take(10)->get();
     $andarbahar_card = DB::table('ab_bet_results')
    ->orderBy('id', 'desc')
    ->select(DB::raw(' random_card, andar_bahar_card, period_no'))
    ->first();

      //dd($andarbahar_card);
      $andarbahar_10results = DB::table('ab_bet_results')
    ->select('id', 'number')
    ->whereNotNull('number')  // Filter out records where 'number' is null
    ->orderBy('id', 'desc') 
    ->take(13) // Take the next 13 results
    ->get()
    ->reverse()  // Reverse the collection to show the last number first
    ->values()   // Reset the array keys
    ->toArray(); // Convert to array

// Transform the results into the desired list format
$results_list = [];
foreach ($andarbahar_10results as $index => $result) {
    $results_list[] = [
        'id' => $result->id,
        'number'   => $result->number
    ];
}

         //dd($andarbahar_10results);
      //$andarbahar_result=DB::table('ab_bet_results')->orderBy('id','desc')->value('random_card','number','andar_bahar_card','period_no');
      //dd($andarbahar_result);
        if ($andarbahar_card) {
            return response()->json(['success' => true, 'message' => 'Andar Bahar result latest data fatch Successfully..!' ,'win_amount' => $win_amt, 'show_result' => $andarbahar_card , 'last_result'=>$results_list]);
        }
        
        return response()->json(['success' => false, 'message' => 'Andar Bahar result latest data not found..!']);

    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}

//  public function results(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'user_id' => 'required'
//     ]);

//     $validator->stopOnFirstFailure();

//     if ($validator->fails()) {
//         return response()->json(['success' => false, 'message' => $validator->errors()->first()], 200);
//     }

   
//     $user_id = $request->user_id;
    
//     try {

//         $gamesno=DB::select("SELECT `period_no` FROM `ab_bet_logs` LIMIT 1;");
//          $period=$gamesno[0]->period_no;
//          $less_no=$period-1;
         
//  $lastwin_amt=DB::select("SELECT SUM(`win_amount`) as win_amount FROM `ab_bets` WHERE `user_id` = $user_id AND `period_no` = $less_no");
//   //dd("SELECT SUM(`win_amount`) as win_amount FROM `lucky12_bets` WHERE `user_id` = $user_id AND `period_no` = $less_no");
//         $win_amt = $lastwin_amt[0]->win_amount ?? 0;
//       $spinresult = DB::select("SELECT * FROM ( SELECT * FROM `ab_bet_results` ORDER BY `id` DESC LIMIT 10 ) AS last_10_results ORDER BY `id` DESC;");
//         if ($spinresult) {
//             return response()->json(['success' => true, 'message' => 'Andar Bahar result latest data fatch Successfully..!' ,'win_amount' => $win_amt, 'data' => $spinresult ]);
//         }
        
//         return response()->json(['success' => false, 'message' => 'Andar Bahar result latest data not found..!']);

//     } catch (Exception $e) {
//         return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
//     }
// }
  	//// Bet History ////

    public function bet_history(Request $request)
	{
	$validator = Validator::make($request->all(), [
	            'user_id'=>'required',
				// 'game_id' => 'required',
		       //'limit' => 'required'
		       	]);
		
    $validator->stopOnFirstFailure();

    if ($validator->fails()) {
        return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
    }
	
	$userid = $request->user_id;
    $game_id = 13;
    $limit = $request->limit ?? 10000;
    $offset = $request->offset ?? 0;
	$from_date = $request->created_at;
	$to_date = $request->created_at;
	//////
	

if (!empty($game_id)) {
    $where['ab_bets.game_id'] = "$game_id";
    $where['ab_bets.user_id'] = "$userid";
}


if (!empty($from_date)) {
    
       $where['ab_bets.created_at']="$from_date%";
  $where['ab_bets.created_at']="$to_date%";
}

$query = " SELECT DISTINCT ab_bets.*, ab_game_settings.name AS game_name, virtual_games.name AS name 
FROM ab_bets
LEFT JOIN ab_game_settings ON ab_game_settings.id = ab_bets.game_id 
LEFT JOIN virtual_games ON virtual_games.game_id = ab_bets.game_id AND virtual_games.number = ab_bets.number" ;

if (!empty($where)) {
    $query .= " WHERE " . implode(" AND ", array_map(function ($key, $value) {
        return "$key = '$value'";
    }, array_keys($where), $where));
}

 $query .= " ORDER BY  ab_bets.id DESC  LIMIT $offset , $limit";
//////
$results = DB::select($query);
$ab_bets=DB::select("SELECT user_id, COUNT(*) AS total_ab_bets FROM ab_bets WHERE `user_id`=$userid GROUP BY user_id
");
$total_bet=$ab_bets[0]->total_ab_bets;
if(!empty($results)){
    ///
		//
		 return response()->json([
            'success' => true,
            'message' => 'Data found',
            'total_ab_bets' => $total_bet,
            'data' => $results
            
        ]);
         return response()->json($response,200);
}else{
    
     //return response()->json(['msg' => 'No Data found'], 400);
    $response = [
    'success' => false,
    'message' => 'No Data found',
    'data' => $results
];

//
return response()->json($response, $response['status']);
         
    
}
		
	}
	
	/// Cron ////
    
    public function cron($game_id)
    {
              $per=DB::select("SELECT ab_game_settings.winning_percentage as winning_percentage FROM ab_game_settings WHERE ab_game_settings.id=$game_id");
        $percentage = $per[0]->winning_percentage;  

            $gameno=DB::select("SELECT * FROM ab_bet_logs WHERE game_id=$game_id LIMIT 1");
            //
            
            ///
            $game_no=$gameno[0]->period_no;
             $period=$game_no;
            
          
				
				
            $sumamt=DB::select("SELECT SUM(amount) AS amount FROM ab_bets WHERE game_id = '$game_id' && period_no='$game_no'");


				
            $totalamount=$sumamt[0]->amount;
		
            $percentageamount = $totalamount*$percentage*0.01; 
			
            $lessamount=DB::select(" SELECT * FROM ab_bet_logs WHERE game_id = '$game_id'  && period_no='$game_no' && amount <= $percentageamount ORDER BY amount asc LIMIT 1 ");
				if(count($lessamount)==0){
				$lessamount=DB::select(" SELECT * FROM ab_bet_logs WHERE game_id = '$game_id'  && period_no='$game_no' && amount >= '$percentageamount' ORDER BY amount asc LIMIT 1 ");
				}
            $zeroamount=DB::select(" SELECT * FROM ab_bet_logs WHERE game_id =  '$game_id'  && period_no='$game_no' && amount=0 ORDER BY RAND() LIMIT 1 ");
            $admin_winner=DB::select("SELECT * FROM ab_admin_winner_result WHERE game_no = '$game_no' AND game_id = '$game_id' ORDER BY id DESC LIMIT 1");
            //  dd($admin_winner);
            $min_max=DB::select("SELECT min(number) as mins,max(number) as maxs FROM ab_bet_logs WHERE game_id=$game_id;");
        if(!empty($admin_winner)){
            echo 'a ';
            $number=$admin_winner[0]->number;
        }
      
        if (!empty($admin_winner)) {
            echo 'b ';
            $res=$number;
        } 
         elseif ( $totalamount< 450) {
             echo 'c ';
            $res= rand($min_max[0]->mins, $min_max[0]->maxs);
        }elseif($totalamount > 450){
            echo 'd ';
            $res=$lessamount[0]->number;
        }
        //$result=$number;
        $result=$res;
    
     $this->andarbaharpatta($game_id, $period, $result);
      

            
                
    }
 
public function insert_random_card()
{
    $gamesno = DB::table('ab_bet_logs')->orderBy('id', 'desc')->value('period_no');

    //dd($gamesno);
      $next_winner = DB::table('andarbahar_cards')->orderBy(DB::raw('RAND()'))->first();
       $next_card_id = $next_winner->id;
       $next_card_value = $next_winner->value;
       $next_card_color = $next_winner->card_color;
       
        // $next_gameno=$gamesno+1;
               
             DB::select("INSERT INTO `ab_bet_results` (`period_no`, `random_card`) 
VALUES (?, ?)", [
    $gamesno,
    json_encode(['id'=>$next_card_id, 'value' => $next_card_value, 'card_color' => $next_card_color])
]);
}


private function andarbaharpatta($game_id, $period, $result){
    $winner = DB::table('ab_bet_results')->orderBy('id', 'desc')->value('random_card');
    $winner_present = json_decode($winner);
    $win_card_id = $winner_present->id;
    $win_card_value = $winner_present->value;

    // Exclude the winner card by value and id for color selection
    $win_card_color = DB::table('andarbahar_cards')
        ->where('value', $win_card_value)
        ->orderBy(DB::raw('RAND()'))
        ->value('card_color');

    // How many random cards to send to frontend
    $card_number = rand(1, 4);

    if ($result == 1) {
        $result_card_id = [];
        $result_json_andar = [];
        $result_json_bahar = [];

        // Generate cards for Andar
        for ($i = 1; $i <= $card_number; $i++) {
            do {
                $query = DB::table('andarbahar_cards')
                    ->where('value', '!=', $win_card_value) // Exclude winner card value
                    ->where('id', '!=', $win_card_id)       // Exclude winner card id
                    ->orderBy(DB::raw('RAND()'))
                    ->first();
            } while (in_array($query->id, $result_card_id));

            $result_card_id[] = $query->id;
            $result_json_andar[] = [
                'value' => $query->value,
                'card_color' => $query->card_color,
                'listData' => 1
            ];
        }

        // Append winner card to Andar
        $result_json_andar[] = [
            'value' => $win_card_value,
            'card_color' => $win_card_color,
            'listData' => 1
        ];

        // Generate cards for Bahar
        $result_card_id_bahar = [];
        for ($i = 1; $i <= $card_number; $i++) {
            do {
                $query = DB::table('andarbahar_cards')
                    ->where('value', '!=', $win_card_value) // Exclude winner card value
                    ->where('id', '!=', $win_card_id)       // Exclude winner card id
                    ->orderBy(DB::raw('RAND()'))
                    ->first();
            } while (in_array($query->id, $result_card_id_bahar));

            $result_card_id_bahar[] = $query->id;
            $result_json_bahar[] = [
                'value' => $query->value,
                'card_color' => $query->card_color,
                'listData' => 2
            ];
        }

        // Merge Andar and Bahar results
        $merged_result = $this->mergeResults($result_json_andar, $result_json_bahar);

        // Update the results in the database
        DB::table('ab_bet_results')
            ->where('period_no', $period)
            ->update([
                'andar_bahar_card' => $merged_result,
                'number' => $result,
                'game_id' => $game_id,
                'status' => 1
            ]);

        DB::select("UPDATE `ab_bet_logs` SET amount=0, period_no=period_no+1 WHERE game_id = '$game_id'");
    } else {
        // Similar logic for when $result is not 1
        $result_card_id = [];
        $result_json_andar = [];
        $result_json_bahar = [];

        // Generate cards for Andar
        for ($i = 1; $i <= $card_number; $i++) {
            do {
                $query = DB::table('andarbahar_cards')
                    ->where('value', '!=', $win_card_value) // Exclude winner card value
                    ->where('id', '!=', $win_card_id)       // Exclude winner card id
                    ->orderBy(DB::raw('RAND()'))
                    ->first();
            } while (in_array($query->id, $result_card_id));

            $result_card_id[] = $query->id;
            $result_json_andar[] = [
                'value' => $query->value,
                'card_color' => $query->card_color,
                'listData' => 1
            ];
        }

        // Generate cards for Bahar
        $result_card_id_bahar = [];
        for ($i = 1; $i <= $card_number - 1; $i++) {
            do {
                $query = DB::table('andarbahar_cards')
                    ->where('value', '!=', $win_card_value) // Exclude winner card value
                    ->where('id', '!=', $win_card_id)       // Exclude winner card id
                    ->orderBy(DB::raw('RAND()'))
                    ->first();
            } while (in_array($query->id, $result_card_id_bahar));

            $result_card_id_bahar[] = $query->id;
            $result_json_bahar[] = [
                'value' => $query->value,
                'card_color' => $query->card_color,
                'listData' => 2
            ];
        }

        // Append winner card to Bahar
        $result_json_bahar[] = [
            'value' => $win_card_value,
            'card_color' => $win_card_color,
            'listData' => 2
        ];

        // Merge Andar and Bahar results
        $merged_result = $this->mergeResults($result_json_andar, $result_json_bahar);

        // Update the results in the database
        DB::table('ab_bet_results')
            ->where('period_no', $period)
            ->update([
                'andar_bahar_card' => $merged_result,
                'number' => $result,
                'game_id' => $game_id,
                'status' => 1
            ]);

        DB::select("UPDATE `ab_bet_logs` SET amount=0, period_no=period_no+1 WHERE game_id = '$game_id'");
    }

    $this->amountdistributioncolors($game_id, $period, $result);
}

// Helper function to merge Andar and Bahar results
private function mergeResults($result_json_andar, $result_json_bahar) {
    $merged_result = [];
    $max_length = min(count($result_json_andar), count($result_json_bahar));

    for ($i = 0; $i < $max_length; $i++) {
        $merged_result[] = $result_json_andar[$i];
        $merged_result[] = $result_json_bahar[$i];
    }

    // If there are extra cards in either array, append them
    if (count($result_json_andar) > count($result_json_bahar)) {
        $merged_result[] = $result_json_andar[count($result_json_andar) - 1];
    }

    return $merged_result;
}





  
	 private function amountdistributioncolors($game_id,$period,$result)
    {
       
        $virtual=DB::select("SELECT name, number, actual_number, game_id, multiplier FROM virtual_games WHERE actual_number='$result' && game_id= '$game_id' AND ((type != 1 AND multiplier != '1.5') OR (type = 1 AND multiplier = '1.5'));");
     //print_r($virtual);

        foreach ($virtual as $winamount) {
            
            $multiple = $winamount->multiplier;

            $number=$winamount->number;
            if(!empty($number)){
				
				if($result == '0'){
					 DB::select("UPDATE ab_bets SET win_amount =(trade_amount*9),win_number= '0',status=1 WHERE period_no='$period' && game_id=  '$game_id' && number =$result");
				}
            
          DB::select("UPDATE ab_bets SET win_amount =(trade_amount*$multiple),win_number= '$result',status=1 WHERE period_no='$period' && game_id=  '$game_id' && number =$number");
        
            }
            
		}
                $uid = DB::select("SELECT  win_amount,  user_id FROM ab_bets where win_number>=0 && period_no='$period' && game_id=  '$game_id' ");
        foreach ($uid as $row) {
             $amount = $row->win_amount;
            $userid = $row->user_id;
      DB::update("UPDATE users SET wallet = wallet + $amount WHERE id = $userid");
        
        }
 
          DB::select("UPDATE ab_bets SET status=2 ,win_number= '$result' WHERE period_no='$period' && game_id=  '$game_id' &&  status=0 && win_amount=0");

            
    }
    
   private function generateRandomString($length = 4) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $maxIndex = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $maxIndex)];
    }

    return $randomString;
}
    

}