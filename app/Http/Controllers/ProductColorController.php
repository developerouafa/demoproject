<?php

namespace App\Http\Controllers;

use App\Models\color;
use App\Models\product;
use App\Models\product_color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductColorController extends Controller
{

    //* function index Product
    public function index($id)
    {
        $product = product::query()->select('id', 'title', 'name_en', 'name_ar', 'description', 'price', 'status', 'category_id', 'parent_id')->where('id',$id)->firstOrFail();
        $product_color  = Product_Color::query()->select('id', 'product_id', 'color')->where('product_id',$id)->get();
        return view('product_color.product_color',compact('product','product_color'));
    }

    //* function create other ProductColor
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'color' => 'required',
        ],[
            'color.required' =>__('messagevalidation.users.colorrequired'),
        ]);
        try{
            DB::beginTransaction();
            $input = $request->all();
            $b_exists = Product_Color::where('product_id', '=', $input['product_id'])->where('color', '=', $input['color'])->exists();
            if($b_exists){
                DB::commit();
                toastr()->error(trans('message.thisexist'));
                return redirect()->back();
            }
            else{
                Product_Color::create([
                    'product_id' => $request->product_id,
                    'color' => $request->color
                ]);
                DB::commit();
                toastr()->success(trans('message.create'));
                return redirect()->back();
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    //* fucntion delete ProductColor
    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            $id = $request->id;
            product_color::findorFail($id)->delete();
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
