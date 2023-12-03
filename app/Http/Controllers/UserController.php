<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BusinessSettings;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
           return DataTables::of(User::all())
           ->addColumn('action', function ($row) {
            return '<a class="btn btn-info btn-sm" href="'. url('/user/edit') . '/'.$row->id.'"> Edit</a>
            <form method="POST" action="'.url('/user/delete').'/'.$row->id.'">
            <input name="_method" type="hidden" value="GET">
            <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                data-toggle="tooltip" title="Delete">Delete</button>
           </form>';
        })->make();
        }
        return view('users.index');
    }

    public function create()
    {
        $businesses = BusinessSettings::get();
        $roles = Role::whereNot('name', 'Supper Admin')->get();
        return view('users.create', compact('roles', 'businesses'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'business' => ['required']
        ]);

        $user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->business_id = $request->business;
        $user->save();
        return to_route('user')->with('success', 'User Created Successfully');
    }




    public function edit($id)
    {
        $businesses = BusinessSettings::get();
        $user =  User::find($id);
        $roles = Role::whereNot('name', 'Supper Admin')->get();
         return view('users.edit', compact('user', 'roles', 'businesses'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'business' => ['required']
            ]);


        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->business_id = $request->business;
        $user->save();
        return to_route('user')->with('success', 'User Updated Successfully');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return to_route('user')->with('success', 'User Deleted Successfully');
    }
}
