<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sizes = size::query()->select('id', 'height', 'width')->where('product_id', $id)->with('product')->get();
        $product = product::where('id', $id)->first();
        return view('sizes.sizes', compact('sizes', 'product'));
    }

    public function update(Request $request)
    {
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
