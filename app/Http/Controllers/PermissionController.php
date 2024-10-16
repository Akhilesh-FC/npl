<?php

namespace App\Http\Controllers;

use App\Models\PermissionsUser;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    $data = [
       
        'Admin' => ["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24"],
        'SuperStokez' => $request->input('SuperStokez', []),
        'Stokez' => $request->input('Stokez', []),
        'Agents' => $request->input('Agents', [])
    ];

    // Convert the data to JSON
    $jsonData = json_encode($data);

    PermissionsUser::where('role_id', 1)->update(['permissions_id' => $jsonData]);

    return redirect()->back()->with('success', 'Permission updated successfully..!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
