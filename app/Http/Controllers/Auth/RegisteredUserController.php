<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'namear' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],[
            'name.required' =>__('messagevalidation.users.namerequired'),
            'name.max' =>__('messagevalidation.users.namemax'),
            'namear.required' =>__('messagevalidation.users.namearrequired'),
            'email.required' =>__('messagevalidation.users.emailrequired'),
            'email.email' =>__('messagevalidation.users.emailemail'),
            'email.unique' =>__('messagevalidation.users.emailunique'),
            'password.required' =>__('messagevalidation.users.passwordrequired'),
        ]);

        try{
            DB::beginTransaction();
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
                'roles_name' => 'role',
            ]);
            event(new Registered($user));
            Auth::login($user);
            DB::commit();
            return redirect(RouteServiceProvider::HOME);
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }
}
