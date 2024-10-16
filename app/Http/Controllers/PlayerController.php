<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PlayerController extends Controller
{
    public function player_index(){
        $users= User::get();
        return view('players.index')->with('user',$users);
    }

    public function PlayerStore(Request $request){

        $validated=$request->validate([
            'email'=>'required',
            'password'=>'required',
            'name'=>'required',
        ]);
        $store = array(
            'email'=>$request->email,
            'password'=>$request->password,
            'name'=>$request->name,
        );

        $users = User::create($store);
        return redirect()->back()->with('success', 'User created successfully!');
    }
}
