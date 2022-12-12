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
            $path = $this->uploadImage($request, 'file1');
            DB::beginTransaction();
            ImageUser::create([
                'user_id' => $request->id,
                'image'=>$path
            ]);
            DB::commit();
            toastr()->success(trans('message.create'));
            return redirect()->route('profile.edit');
        }
        catch(\Exception $exception){
            DB::rollBack();
            return 'erreur';
        }
        // $path = $this->uploadImage($request, 'file1');
        // return $path;
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
            $idimageuser = $request->id;
            $imageuser = ImageUser::findOrFail($idimageuser);
            if($request->has('imageuser')){
                    $image = $imageuser->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$imageuser->image));
                    $image = $this->uploadImage($request, 'file1');
                    DB::beginTransaction();
                    $imageuser->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('profile.edit');
            }
            else{
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
        $id = Auth::user()->id;
        $imageuser = ImageUser::findorFail($id);
        DB::beginTransaction();
        $imageuser->delete();
        $image = $imageuser->image;
        if(!$image) abort(404);
        unlink(public_path('storage/'.$imageuser->image));
        DB::commit();
        toastr()->success(trans('message.delete'));
        return redirect()->route('profile.edit');
    }
}
