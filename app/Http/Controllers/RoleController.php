<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
// For Middleware
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller // implements HasMiddleware
{
    // public static function middleware(): array{
    //     return [
    //         new Middleware ('permission:view roles',  only: ['index']),
    //         new Middleware ('permission:edit roles',  only: ['edit']),
    //         new Middleware ('permission:create roles',  only: ['create']),
    //         new Middleware ('permission:delete roles',  only: ['destroy']),
    //     ];
    // }
    // This method will show role page
    public function index()
    {
        abort_if(Gate::denies('read roles'), 403);

        $roles = Role::orderBy('name', 'ASC')->paginate(8);

        return view('roles.list', [
            'roles' => $roles,
        ]);

        // if (auth()->user()->can('read roles')) {
        // } else {
        //     abort(403, 'You are not authorized to view roles');
        // }
    }

    // This method will show create role page
    public function create()
    {
        abort_if(Gate::denies('create roles'), 403);

        $permissions = Permission::orderBy('name', 'DESC')->get();

        return view('roles.create', [
            'permissions' => $permissions,
        ]);
    }

    // This method will store role in DB
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3,name',
        ]);
        if ($validator->passes()) {
            // dd($request->permission);
            $role = Role::create([
                'name' => $request->name,
            ]);

            if (! empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('roles.index')->with('success', 'Role created successfully');

        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    // Function that will show edit role page
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'DESC')->get();
        // dd($hasPermissions);

        return view('roles.edit', [
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions,
            'role' => $role,
        ]);
    }

    // Function that will update role in DB
    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id.',id',
        ]);
        if ($validator->passes()) {
            // dd($request->permission);
            // $role = Role::create(['name' => $request->name,]);
            $role->name = $request->name;
            $role->save();

            if (! empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success', 'Role Updated successfully');

        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    // Route that Destroy role from DB
    public function destroy(Request $request)
    {
        $id = $request->id;

        $role = Role::find($id);
        if ($role == null) {

            session()->flash('error', 'Role not found');

            return response()->json([
                'status' => false,
            ]);
        }

        $role->delete();

        session()->flash('success', 'Role deleted successfully');

        return response()->json([
            'status' => true,
        ]);

    }
}
