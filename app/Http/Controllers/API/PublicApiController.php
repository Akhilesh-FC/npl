<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PublicApiController extends Controller
{
    public function Login(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('mobile', $request->mobile)->where('password',$request->password)->first();
        if($user){         
            $response = [
                'success' => true,
                'message' => 'User login successfully',
                'id' => $user->id,      
            ];
        
            return response()->json($response);
        }else{
            return response()->json(['success'=>false,'message' => 'The provided credentials do not match our records.']);    
        }
    }catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
    }
    //profile
    public function Profile($id){
    try{
       $user =  User::find($id);
       if($user){
        return response()->json(['success'=>true,'message' => 'User found..!', 'data' =>$user ]); 
       }
       return response()->json(['success'=>false,'message' => 'User not found..!']);   
    }catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
    }
  
}
