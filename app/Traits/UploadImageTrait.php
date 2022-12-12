<?php

namespace App\Traits;
use Illuminate\Http\Request;

trait UploadImageTrait
{
    public function uploadImage(Request $request, $folderName){
        $image = $request->file('imageuser')->getClientOriginalName();
        // hash
        $path = $request->file('imageuser')->store($folderName, 'public');
        return $path;
    }
}
