<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //* Add product in cart
    public function store(Request $request, $id)
    {
        try{
            $Product = product::findOrFail($id);
            $rowId = time().rand(1,1000);
            $user_id = Auth::user()->id;

            // add the product to cart
            DB::beginTransaction();
            \Cart::session($user_id)->add(array(
                'id' => $rowId,
                'name' => $Product->title,
                'price' => $Product->price,
                'quantity' => $request->quantity,
                'attributes' => array(),
                'associatedModel' => $Product
            ));
            DB::commit();
            toastr()->success(trans('message.addincart'));
            return redirect()->back();
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('category_index');
        }
    }

    public function update(Request $request)
    {
        try{
            $rowId = $request->id;
            $user_id = Auth::user()->id;
            DB::beginTransaction();
                \Cart::session($user_id)->update($rowId,[
                    'quantity' => $request->quantity
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

    public function delete($id)
    {
        try{
            $rowId = $id;
            $user_id = Auth::user()->id;
            DB::beginTransaction();
                \Cart::session($user_id)->remove($rowId);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    public function deleteall(Request $request){
        try{
            $user_id = Auth::user()->id;
            DB::beginTransaction();
            \Cart::session($user_id)->clear();
            DB::commit();
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            return redirect()->back();
        }
    }
}
