<?php

namespace App\Http\Controllers;

use App\Models\image;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    //* function Index Image
    public function index($id)
    {
        $Product = product::where('id',$id)->firstOrFail();
        $images  = image::selectimage()->where('product_id',$id)->get();
        return view('images.images',compact('Product','images'));
    }

    //* function store Image
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'image' => 'required',
        ],[
            'image.required' =>__('messagevalidation.users.imagerequired')
        ]);
        try{
            //Added photo
            if($request->has('image')){
                DB::beginTransaction();
                    foreach($request->file('image') as $image){
                        $imageName = '-image'.time().rand(1,1000).'.'.$image->extension();
                        $image->move(public_path('product_images'),$imageName);
                        image::create([
                            'product_id' => $request->product_id,
                            'multimg' => $imageName
                        ]);
                    }
                    DB::commit();
                    toastr()->success(trans('message.create'));
                    return redirect()->back();
            }
            // No Add photo
            else{
                toastr()->error(trans('messagevalidation.users.imagerequired'));
                return redirect()->back();
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    //* function delete Image
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            DB::beginTransaction();
                image::findorFail($id)->delete();
            DB::commit();
                toastr()->success(trans('message.delete'));
                return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }
}
