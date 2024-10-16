<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class SuperStokezController extends Controller
{
    public function super_stokez_index(){
        $users = User::get();

        return view('super_stokez.index')->with('users',$users);
    }

    public function SuperStokezStore(Request $request)
{



    $validated = $request->validate([
        'email' => 'required',
        'password' => 'required',
        'name' => 'required',
        'revenue' => 'required',
    ]);

    $data = array(
        'email' => $request->email,
        'password' => $request->password,
        'name' => $request->name,
        'revenue' => $request->revenue,
        'role_id' => 2, // Ensure this field is included
    );

    $users = User::create($data);

    return redirect()->back()->with('success', 'User created successfully!');
}
}
