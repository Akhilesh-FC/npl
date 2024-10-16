<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokezSettingController extends Controller
{
    public function stokezSetting_index(){
        return view('stokezSetting.index');
    }
}
