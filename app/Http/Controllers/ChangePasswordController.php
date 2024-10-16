<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function changePassword_index(){
        return view('changePassword.index');
    }
}
