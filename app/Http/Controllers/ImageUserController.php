<?php

namespace App\Http\Controllers;

use App\Models\ImageUser;
use App\Models\User;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImageUserController extends Controller
{

    Use UploadImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageUser  $imageUser
     * @return \Illuminate\Http\Response
     */
    public function show(ImageUser $imageUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImageUser  $imageUser
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageUser $imageUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImageUser  $imageUser
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImageUser  $imageUser
     * @return \Illuminate\Http\Response
     */
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
