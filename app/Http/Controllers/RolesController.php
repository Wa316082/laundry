<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;


class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Roles View')->only(['index']);
        $this->middleware('permission:Roles Create')->only(['create', 'store']);
        $this->middleware('permission:Roles Edit')->only(['edit', 'update']);
        $this->middleware('permission:Roles Delete')->only(['delete']);
    }
    public function index()
    {
        $roles = Role::whereNot('name', 'Supper Admin')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }


    public function store(Request $request)
    {
       $validated = $request->validate(['name' => ['required','min:3']]);

       Role::create($validated);
       return to_route('roles')->with('success', 'Success! Roles Created');
    }

    public function edit( $id)
    {
       $role = Role::find($id);
       return view('roles.edit', compact('role'));
    }


    public function update(Request $request , Role $role)
    {
        $validated = $request->validate(['name'=>['required', 'min:3']]);
        $role->update($validated);
        return \to_route('roles');
    }


    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();
        return to_route('roles');
    }


    public function assignPermission($id)
    {
        $role = Role::find($id);
        $permissions = Permission::select('id', 'name')
        ->selectRaw("CASE WHEN permissions.id IN (
            SELECT permission_id FROM role_has_permissions WHERE role_id = $role->id
        ) THEN '1' ELSE '0' END AS permitted")
        ->get();
        // dd($permissions);
        return view('roles.assign_permission', compact('role', 'permissions',));
    }


    public function permissionStore(Request $request, Role $role)
    {
        $permissions = $request->permission;
        $role->syncPermissions($permissions);
        return to_route('roles')->with('success', 'Permission Given');
    }
}
