<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\image;
use App\Models\Post;
use App\Models\product;
use App\Models\product_color;
use App\Models\size;
use App\Models\User;
use App\Notifications\productntf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    //* function index Product
    public function index()
    {
        $products = product::query()->productselect()->productwith()->get();
        $childrens = category::query()->selectchildrens()->withchildrens()->child()->get();
        $categories = category::query()->selectcategories()->withcategories()->parent()->get();
        return view('products.products', compact('products', 'categories', 'childrens'));
    }

    //* DropDown Children
    public function getchildproduct($id)
    {
        $childrens = DB::table("categories")->where("parent_id", $id)->pluck("id", 'id');
        return json_encode($childrens);
    }

    //* Hide Product
    public function editstatusdéactive($id)
    {
        try{
            $product = Product::findorFail($id);
            DB::beginTransaction();
            $product->update([
                'status' => 1,
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* Show Product
    public function editstatusactive($id)
    {
        try{
            $product = Product::findorFail($id);
            DB::beginTransaction();
            $product->update([
                'status' => 0,
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* Create Product
    public function create()
    {
        $products = product::query()->productselect()->productwith()->get();
        $childrens = category::query()->selectchildrens()->withchildrens()->child()->get();
        $categories = category::query()->selectcategories()->withcategories()->parent()->get();
        return view('products.productscreate', compact('products', 'categories', 'childrens'));
    }

    //* function create other Product
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'title_en' => 'required|unique:products,title->en',
            'title_ar' => 'required|unique:products,title->ar',
            'description_en' => 'required|unique:products,description->en',
            'description_ar' => 'required|unique:products,description->ar',
            'image' => 'required',
            'Category'  => 'required',
            'children'  => 'required',
            'price' => 'required|between:1,99999999999999',
            'color' => 'required',
            'width' => 'required',
            'height' => 'required',
        ],[
            'title_en.required' =>__('messagevalidation.users.titleenrequired'),
            'title_en.unique' =>__('messagevalidation.users.titleaddenunique'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'title_ar.unique' =>__('messagevalidation.users.titleaddarunique'),
            'description_en.required' =>__('messagevalidation.users.bodyenrequired'),
            'description_ar.required' =>__('messagevalidation.users.bodyarrequired'),
            'image.required' =>__('messagevalidation.users.imagerequired'),
            'Category.required' =>__('messagevalidation.users.categoryrequired'),
            'children.required' =>__('messagevalidation.users.childrenrequired'),
            'price.required' =>__('messagevalidation.users.priceisrequired'),
            'price.between' =>__('messagevalidation.users.priceislow'),
            'width.required' =>__('messagevalidation.users.widthisrequired'),
            'height.required' =>__('messagevalidation.users.heightisrequired')
        ]);
        try{
            //Added photo
            if($request->has('image')){
                DB::beginTransaction();
                product::create([
                    'title' => ['en' => $request->title_en, 'ar' => $request->title_ar],
                    'description' => ['en' => $request->description_en, 'ar' => $request->description_ar],
                    'category_id' => $request->Category,
                    'parent_id' => $request->children,
                    'status' => 0,
                    'price' => $request->price
                ]);
                    $product_id = product::latest()->first()->id;
                    foreach($request->file('image') as $image){
                        $imageName = '-image'.time().rand(1,1000).'.'.$image->extension();
                        $image->move(public_path('product_images'),$imageName);
                        image::create([
                            'product_id'=>$product_id,
                            'multimg'=>$imageName
                        ]);
                    }

                    product_color::create([
                        'product_id'=>$product_id,
                        'color'=>$request->color
                    ]);

                    $size = new size();
                    $size->product_id = $product_id;
                    $size->height = $request->height;
                    $size->width = $request->width;
                    $size->save();

                    //* Notification database Product
                    $users = User::where('id', '!=', Auth::user()->id)->get();
                    $user_create = Auth::user()->name;
                    $idd = product::latest()->first();
                    $title = product::latest()->first();
                    $body = product::latest()->first();
                    Notification::send($users, new productntf($idd, $user_create, $title, $body));

                    DB::commit();
                    toastr()->success(trans('message.create'));
                    return redirect()->route('product_index');
            }
            // No Added photo
            else{
                toastr()->error(trans('messagevalidation.users.imagerequired'));
                return redirect()->route('product_index');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* function ipdate Product
    public function update(Request $request)
    {
        $this->validate($request, [
            'title_'.app()->getLocale() => 'required|unique:products,title->'.app()->getLocale().','.$request->id,
            'description_'.app()->getLocale() => 'required',
            'price' => 'required|between:1,99999999999999',
            'Category'  => 'required',
            'children'  => 'required',
        ],[
            'title_'.app()->getLocale().'.required' =>__('messagevalidation.users.titlerequired'),
            'title_'.app()->getLocale().'.unique' =>__('messagevalidation.users.titlunique'),
            'description_'.app()->getLocale().'.required' =>__('messagevalidation.users.bodyrequired'),
            'price.required' =>__('messagevalidation.users.priceisrequired'),
            'price.between' =>__('messagevalidation.users.priceislow'),
            'Category.required' =>__('messagevalidation.users.categoryrequired'),
            'children.required' =>__('messagevalidation.users.childrenrequired')
        ]);
        try{
            $product = $request->id;
            $productupdate = product::findOrFail($product);
                DB::beginTransaction();
                if(App::isLocale('en')){
                    $productupdate->update([
                        'title' => $request->title_en,
                        'description' => $request->description_en,
                        'price' => $request->price,
                        'category_id' => $request->Category,
                        'parent_id' => $request->children
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $productupdate->update([
                        'title' => $request->title_ar,
                        'description' => $request->description_ar,
                        'price' => $request->price,
                        'category_id' => $request->Category,
                        'parent_id' => $request->children
                    ]);
                }
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('product_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* function delete Product
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $images  = image::select('multimg')->where('product_id',$id)->get();
            foreach($images as $x){
                if(!$x->multimg) abort(404);
                unlink(public_path('product_images/'.$x->multimg));
            }
            $product = product::findorFail($id);
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('product_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

}
