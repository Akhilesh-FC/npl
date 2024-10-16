<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionReportController extends Controller
{
    public function transactionReport_index(){
        return view('transactionReport.index');
    }
}
