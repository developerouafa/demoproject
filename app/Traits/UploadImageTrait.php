<?php

namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadImageTrait
{

    public function uploadImage(Request $request, $folderName){
        $image = $request->file('imageuser')->getClientOriginalName();
        // hash
        $path = $request->file('imageuser')->store($folderName, 'public');
        return $path;
    }

    public function uploadImagecategory(Request $request, $folderName){
        $image = $request->file('image')->getClientOriginalName();
        // hash
        $path = $request->file('image')->store($folderName, 'public');
        return $path;
        // $time = time();
        // $logoPath = $request->file('image');
        // $image = "{$time}.{$logoPath->getClientOriginalExtension()}";
        // // $image = $request->file('image')->getClientOriginalName();
        //         Storage::putFileAs(
        //             // store($folderName, 'public'),
        //             $folderName,
        //             $request->file('image'),
        //             $image,
        //         );
        // return $image;
    }

    public function uploadImageChildrenCat(Request $request, $folderName){
        $image = $request->file('image')->getClientOriginalName();
        // hash
        $path = $request->file('image')->store($folderName, 'public');
        return $path;
    }
}
