<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// namespace App\Http\Controllers\UserManagement;
//custom Spatie\Permission
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.show_users',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.Add_user',compact('roles'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password'
        ]);
        $user = User::create([
            'name' => ['en' => $request->name, 'ar' => $request->namear],
            'nickname' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'github_id' => 'null',
            'firstname' => 'null',
            'lastname' => 'null',
            'designation' => 'null',
            'website' => 'null',
            'phone' => 'null',
            'Address' => 'null',
            'twitter' => 'null',
            'facebook' => 'null',
            'google' => 'null',
            'linkedin' => 'null',
            'github' => 'null',
            'biographicalinfo' => 'null',
            'roles_name' => $request->roles_name,
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        // $request->name = ['en' => $request->name, 'ar' => $request->namear];
        // $input = $request->all();
        // $input['password'] = Hash::make($input['password']);
        // $user = User::create($input);
        $user->assignRole($request->input('roles'));
        toastr()->success(trans('message.create'));
        return redirect()->route('users.index');
        // return redirect()->route('users.index')->with('success','User created successfully');
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'same:confirm-password',
        'roles' => 'required'
        ]);
        $input = $request->all();
        if(!empty($input['password'])){
        $input['password'] = Hash::make($input['password']);
        }else{
        $input = array_except($input,array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        toastr()->success(trans('message.update'));
        return redirect()->route('users.index');
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        toastr()->success(trans('message.delete'));
        return redirect()->route('users.index');
        // return redirect()->route('users.index')->with('success','User deleted successfully');
    }
}

