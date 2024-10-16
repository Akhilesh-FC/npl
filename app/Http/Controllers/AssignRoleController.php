<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Permission,PermissionsUser};

class AssignRoleController extends Controller
{
    public function assignRole_index(){
        $permission = Permission::where('status',1)->get();
        $PermissionsUser = PermissionsUser::where('id',1)->first();
        $permissionsData = json_decode($PermissionsUser->permissions_id, true);
        return view('assignRole.index')->with('permission',$permission)->with('permissionsData',$permissionsData);
    }
}
