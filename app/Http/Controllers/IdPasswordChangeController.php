<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdPasswordChangeController extends Controller
{
    public function idPasswordChange_index(){
        return view('idPasswordChange.index');
    }
}
