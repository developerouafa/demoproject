<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProviderGithub(){
        return Socialite::driver('github')->redirect();
    }

    public function handleCallbackGithub(){
        try{
            $user = Socialite::driver('github')->user();
        } catch(\Exception $e){
            return redirect('/login');
        }

        // dd($user);

        $existingUser = User::where('github_id', $user->id)->first();

        if($existingUser){
            Auth::login($existingUser);
        }
        else{
            $newUser = User::create([
                'name' => $user->nickname,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'github_id' => $user->id,
                'password' => $user->token,
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
                'biographicalinfo' => 'null'
            ]);

            Auth::login($newUser, true);
        }
        return redirect()->to('/offers/dashboard');
    }
}
