<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{
    //* function index Size
    public function index($id)
    {
        $sizes = size::query()->selectsize()->where('product_id', $id)->with('product')->get();
        $product = product::where('id', $id)->first();
        return view('sizes.sizes', compact('sizes', 'product'));
    }

    //* function update Size
    public function update(Request $request)
    {
        // validations
        $this->validate($request, [
            'width' => 'required',
            'height' => 'required',
        ],[
            'width.required' =>__('messagevalidation.users.widthisrequired'),
            'height.required' =>__('messagevalidation.users.heightisrequired')
        ]);
        try{
            $product_id = $request->id;
            $size = size::findOrFail($product_id);
            DB::beginTransaction();
                $size->update([
                    'height' => $request->height,
                    'width' => $request->width
                ]);
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }
}
