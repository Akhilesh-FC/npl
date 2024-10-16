<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StokezController extends Controller
{
    public function stokez_index(){
        $users = User::get();
        return view('stokez.index')->with('users',$users);
    }
    public function StokezStore(Request $req){
        $validated = $req->validate([
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'revenue' => 'required',
        ]);

        $data = array(
            'email' => $req->email,
            'password' => $req->password,
            'name' => $req->name,
            'revenue' => $req->revenue,
            'role_id' => 3, // Ensure this field is included
        );

        $users = User::create($data);

        return redirect()->back()->with('success', 'User created successfully!');
    }


    }



