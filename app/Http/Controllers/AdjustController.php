<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdjustController extends Controller
{
    public function adjust_index(){
        return view('adjust.index');
    }
}
