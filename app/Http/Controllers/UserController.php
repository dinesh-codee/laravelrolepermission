<?php

namespace App\Http\Controllers;

use App\Models\User;
// Role model inporter
use Illuminate\Http\Request;
// Import validator
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
// For Middleware
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller // implements HasMiddleware
{
    // public static function middleware(): array{
    //     return [
    //         new Middleware ('permission:view users',  only: ['index']),
    //         new Middleware ('permission:edit users',  only: ['edit']),
    //         // new Middleware ('permission:create users',  only: ['create']),
    //         // new Middleware ('permission:delete users',  only: ['destroy']),
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('read users'), 403);
        $users = User::latest()->paginate(5);
    
        return view('users.list', [
            'users' => $users,
        ]);
        // if (auth()->user()->can('read users')) {
        // } else {
        //     abort(403, 'You are not authorized to view users');
        // }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $roles = Role::orderBy('name', 'ASC')->get();

        $hasRole = $user->roles->pluck('id');

        // dd($hasRole);
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'hasRole' => $hasRole,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validate = Validator::make($request->all(), [
            'name' => 'required|min:3   ',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        if ($validate->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validate);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // ASSIGN ROLE TO USER
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
