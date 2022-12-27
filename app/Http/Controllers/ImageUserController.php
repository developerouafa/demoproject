<?php

namespace App\Http\Controllers;

use App\Models\ImageUser;
use App\Models\User;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageUserController extends Controller
{
    Use UploadImageTrait;

    public function store(Request $request)
    {
        try{
            $input = $request->all();
            if(!empty($input['imageuser'])){
                $path = $this->uploadImage($request, 'file1');
                DB::beginTransaction();
                ImageUser::create([
                    'user_id' => $request->id,
                    'image'=>$path
                ]);
                DB::commit();
                toastr()->success(trans('message.create'));
                return redirect()->route('profile.edit');
            }else{
                toastr()->error(trans('messagevalidation.users.imageuserrequired'));
                return redirect()->route('profile.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            return 'erreur';
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'imageuser' => ['required'],
        ],[
            'imageuser.required' =>__('messagevalidation.users.imageuserrequired'),
        ]);
        try{
            $idimageuser = Auth::user()->id;
            $tableimageuser = ImageUser::where('user_id','=',$idimageuser)->first();
            if($request->has('imageuser')){
                    $image = $tableimageuser->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImage($request, 'file1');
                    DB::beginTransaction();
                    $tableimageuser->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('profile.edit');
            }
            else{
                toastr()->error(trans('messagevalidation.users.imageuserrequired'));
                return redirect()->route('profile.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('profile.edit');
        }
    }

    public function destroy(ImageUser $imageUser)
    {
        try{
            $id = Auth::user()->id;
            $tableimageuser = ImageUser::where('user_id','=',$id)->first();
            DB::beginTransaction();
            $tableimageuser->delete();
            $image = $tableimageuser->image;
            if(!$image) abort(404);
            unlink(public_path('storage/'.$image));
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('profile.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('profile.edit');
        }
    }

}
