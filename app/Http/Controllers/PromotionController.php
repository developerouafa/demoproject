<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    //* function index Promotion
    public function index($id)
    {
        $promotion = promotion::query()->where('product_id', $id)->with('product')->get();
        $product = product::where('id', $id)->first();
        return view('promotions.promotions', compact('promotion', 'product'));
    }

    //* function create other Promotion
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'price' => 'required|between:1,99999999999999',
            'start_time' => 'required',
            'end_time' => 'required',
        ],[
            'price.required' =>__('messagevalidation.users.priceisrequired'),
            'price.between' =>__('messagevalidation.users.priceislow'),
            'start_time.required' =>__('messagevalidation.users.start_timerequired'),
            'end_time.required' =>__('messagevalidation.users.end_timerequired'),
        ]);
        try{
                $id = $request->id;
                $product = product::findOrFail($id);
                DB::beginTransaction();
                    promotion::create([
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'price' => $request->price,
                        'product_id' => $product->id
                    ]);
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

    //* function update other Promotion
    public function update(Request $request)
    {
        // validations
        $this->validate($request, [
            'price' => 'required|between:1,99999999999999',
            'start_time' => 'required',
            'end_time' => 'required',
        ],[
            'price.required' =>__('messagevalidation.users.priceisrequired'),
            'price.between' =>__('messagevalidation.users.priceislow'),
            'start_time.required' =>__('messagevalidation.users.start_timerequired'),
            'end_time.required' =>__('messagevalidation.users.end_timerequired'),
        ]);
        try{
            $promotion_id = $request->id;
            $promotion = Promotion::findOrFail($promotion_id);
            DB::beginTransaction();
                $promotion->update([
                    'price' => $request->price,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time
                ]);
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    //* Hide Promotion
    public function editstatusdéactive($id)
    {
        try{
            $Promotion = promotion::findorFail($id);
            DB::beginTransaction();
            $Promotion->update([
                'expired' => 1,
            ]);
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    //* show Promotion
    public function editstatusactive($id)
    {
        try{
            $Promotion = promotion::findorFail($id);
            DB::beginTransaction();
            $Promotion->update([
                'expired' => 0,
            ]);
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    //* function delete other Promotion
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $promotion = promotion::findorFail($id);
            DB::beginTransaction();
                $promotion->delete();
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
