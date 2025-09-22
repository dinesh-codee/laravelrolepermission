<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


use Illuminate\Http\Request;

class RoleController extends Controller
{
    // This method will show role page
    public function index(){

    }

    // This method will show create role page
    public function create(){

        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.create',[
            'permissions' => $permissions
        ]);
    }

    // This method will store role in DB
    public function store(){
        $validator =  Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3,name',
        ]);
        if($validator->passes()){
            Role::create([
                'name' => $request->name,
            ]);
            return redirect()->route('permissions.index')->with('success', 'Permission created successfully'); 

        }else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    } 
}
