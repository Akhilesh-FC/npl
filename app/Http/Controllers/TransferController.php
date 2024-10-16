<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function transfer_index(){
        return view('transfer.index');
    }
}
