<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerSecurityController extends Controller
{
    public function playerSecurity_index(){
        return view('playerSecurity.index');
    }
}
