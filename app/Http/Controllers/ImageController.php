<?php

namespace App\Http\Controllers;

use App\Models\image;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function index($id)
    {
        $Product = product::where('id',$id)->firstOrFail();
        $images  = image::where('product_id',$id)->get();
        return view('images.images',compact('Product','images'));
    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();
            Image::findorFail($id)->delete();
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
        ],[
            'image.required' =>__('messagevalidation.users.imagerequired')
        ]);
        try{
            $id = $request->product_id;
            $product = product::findOrFail($id);
            if(!$product) abort(404);
            if($request->has('image')){
                foreach($request->file('image') as $image){
                    $imageName = '-image'.time().rand(1,1000).'.'.$image->extension();
                    $image->move(public_path('product_images'),$imageName);
                DB::beginTransaction();
                    Image::create([
                    'product_id'=>$product->id,
                    'multimg'=>$imageName
                    ]);
                }
            }
            DB::commit();
            toastr()->success(trans('message.create'));
            return redirect()->back();
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }
}
