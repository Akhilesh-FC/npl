<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TurnOverReportController extends Controller
{
    public function turnOverReport_index(){
        return view('turnOverReport.index');
    }
}
