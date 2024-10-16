<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AgentController extends Controller
{
    public function agent_index(){
        $users= User::get();
        return view('agent.index')->with('users',$users);
    }

    public function agentStore(Request $request){

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
