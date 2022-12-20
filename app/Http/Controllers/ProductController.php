<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\color;
use App\Models\image;
use App\Models\Post;
use App\Models\product;
use App\Models\product_color;
use App\Models\size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::query()->select('id', 'title', 'name_en', 'name_ar', 'description', 'price', 'status', 'category_id', 'parent_id')->productwith();
        $childrens = category::query()->select('id', 'title', 'name_ar', 'name_en', 'status', 'image', 'parent_id')->with('subcategories')->child()->get();
        $categories = category::query()->select('id', 'title', 'image', 'status','parent_id')->with('category')->parent()->get();
        $posts = Post::query()->select('id', 'title','body', 'category_id', 'parent_id', 'image')->with('category')->with('subcategories')->get();
        return view('products.products', compact('products', 'categories', 'childrens'));
    }

    public function getchildproduct($id)
    {
        $childrens = DB::table("categories")->where("parent_id", $id)->pluck("id", 'name_'.app()->getLocale().'');
        return json_encode($childrens);
    }

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
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

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

    public function create()
    {
        $products = product::query()->select('id', 'title', 'name_en', 'name_ar', 'description', 'price', 'status', 'category_id', 'parent_id')->productwith();
        $categories = category::query()->select('id', 'title', 'image', 'status','parent_id')->with('category')->parent()->get();
        $childrens = category::query()->select('id', 'title', 'name_ar', 'name_en', 'status', 'image', 'parent_id')->with('subcategories')->child()->get();
        return view('products.productscreate', compact('products', 'categories', 'childrens'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'title_ar' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'image' => 'required',
            'Category'  => 'required',
            'children'  => 'required',
            'price' => 'required|between:1,99999999999999',
            'color' => 'required',
            'width' => 'required',
            'height' => 'required',
        ],[
            'title.required' =>__('messagevalidation.users.titleenrequired'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'description.required' =>__('messagevalidation.users.bodyenrequired'),
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
            if($request->has('image')){
                DB::beginTransaction();
                product::create([
                    'title' => ['en' => $request->title, 'ar' => $request->title_ar],
                    'description' => ['en' => $request->description, 'ar' => $request->description_ar],
                    'category_id' => $request->Category,
                    'parent_id' => $request->children,
                    'name_en' => $request->title,
                    'name_ar' => $request->title_ar,
                    'status' => 0,
                    'price' => $request->price
                ]);
                    $product_id = product::latest()->first()->id;
                    foreach($request->file('image') as $image){
                        $imageName = '-image'.time().rand(1,1000).'.'.$image->extension();
                        $image->move(public_path('product_images'),$imageName);
                        // $image = $this->uploadImageproducts($request, 'fileproducts');
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

                    // $users = admin_user::where('id', '!=', Auth::guard('admin_users')->user()->id)->get();
                    // $user_create = Auth::guard('admin_users')->user()->name;
                    // $product_id = Product::latest()->first();
                    // Notification::send($users, new Productntf($product_id, $user_create, $request->title, $request->description));

                    DB::commit();
                    toastr()->success(trans('message.create'));
                    return redirect()->route('product_index');
            }
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
