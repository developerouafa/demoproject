<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ImageUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $id = Auth::user()->id;
        $imageuser = User::query()->select('id')->where('id', '=', $id)->with('image')->get();
        return view('profile.edit', ['user' => $request->user(),], compact('imageuser'));
    }

    public function updateprofile(ProfileUpdateRequest $request)
    {
        try{
            DB::beginTransaction();
            $request->user()->fill($request->validated());

            $request->user()->save();
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->route('profile.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('profile.edit');
        }
    }

    public function updatemail(EmailUpdateRequest $request)
    {
        try{
            DB::beginTransaction();
            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
            $request->user()->save();
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->route('profile.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('profile.edit');
        }

    }

    public function destroy(Request $request)
    {
        try{
            DB::beginTransaction();
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current-password'],
            ]);

            $user = $request->user();

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            DB::commit();
            return Redirect::to('/');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('profile.edit');
        }
    }
}
