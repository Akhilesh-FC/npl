<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultHistoryController extends Controller
{
    public function resultHistory_index(){
        return view('resultHistory.index');
    }
}
