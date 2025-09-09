<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    # This method will show permission page
    public function index(){
        $permissions = Permission::orderBy('created_at','DESC')->paginate(20);
        return view('permissions.list',[
            'permissions' => $permissions
        ]);
    }

    # This method will show create permission page
    public function create(){
        return view('permissions.create');
    }

    # This method will show store in DB permission page
    public function store(Request $request){
        $validator =  Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3,name',
        ]);
        if($validator->passes()){
            Permission::create([
                'name' => $request->name,
            ]);
            return redirect()->route('permissions.index')->with('success', 'Permission created successfully'); 

        }else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    # This method will show edit permission page
    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('permissions.edit',[
            'permission' => $permission
        ]);


    }

    # This method will show update permission page
    public function update($id, Request $request){
        $permission = Permission::findOrFail($id);

        $validator =  Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
        ]);
        if($validator->passes()){
            // Permission::create([
            //     'name' => $request->name,
            // ]);

            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success', 'Permission Updated Successfully'); 

        }else{
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    # This method will show delete  in DB
    public function delete(){
        
    }
}
