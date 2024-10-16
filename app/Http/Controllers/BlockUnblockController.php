<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlockUnblockController extends Controller
{
    public function blockUnblock_index(){
        return view('blockUnblock.index');
    }
}
