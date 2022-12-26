<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //* Page UploadImageTrait inside it function Image
    Use UploadImageTrait;

    //* function index Catgeory
    public function index()
    {
        $categoriesindex = category::query()->selectcategories()->withcategories()->parent()->get();
        return view('categories.categories', compact('categoriesindex'));
    }

    //* function create other category
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'title_en' => 'required|unique:categories,title->en',
            'title_ar' => 'required|unique:categories,title->ar',
        ],[
            'title_en.required' =>__('messagevalidation.users.titleenrequired'),
            'title_en.unique' =>__('messagevalidation.users.titleaddenunique'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'title_ar.unique' =>__('messagevalidation.users.titleaddarunique'),
        ]);
        try{
            //Added photo
            if($request->has('image')){
                $image = $this->uploadImagecategory($request, 'filecategory');
                DB::beginTransaction();
                category::create([
                    'title' => ['en' => $request->title_en, 'ar' => $request->title_ar],
                    'status' => 0,
                    'image' => $image
                ]);
                DB::commit();
                toastr()->success(trans('message.create'));
                return redirect()->route('category_index');
            }
            // No Added photo
            else{
                toastr()->error(trans('messagevalidation.users.imagerequired'));
                return redirect()->route('category_index');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('category_index');
        }
    }

    //* Hide category
    public function editstatusdéactive($id)
    {
        try{
            $categories = category::findorFail($id);
            DB::beginTransaction();
            $categories->update([
                'status' => 1,
            ]);
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->route('category_index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('category_index');
        }
    }

    //* show category
    public function editstatusactive($id)
    {
        try{
            $categories = category::findorFail($id);
            DB::beginTransaction();
            $categories->update([
                'status' => 0,
            ]);
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->route('category_index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('category_index');
        }
    }

    //* fucntion update category
    public function update(Request $request)
    {
        // validations
        $this->validate($request, [
            'title_'.app()->getLocale() => 'required|unique:categories,title->'.app()->getLocale().','.$request->id,
        ],[
            'title_'.app()->getLocale().'.required' =>__('messagevalidation.users.titlerequired'),
            'title_'.app()->getLocale().'.unique' =>__('messagevalidation.users.titlunique')
        ]);
        try{
            $category = $request->id;
            $categories = category::findOrFail($category);
            if($request->has('image')){
                $image = $categories->image;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
                $image = $this->uploadImagecategory($request, 'filecategory');
                DB::beginTransaction();
                if(App::isLocale('en')){
                    $categories->update([
                        'title' => $request->title_en,
                        'image' => $image
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $categories->update([
                        'title' => $request->title_ar,
                        'image' => $image
                    ]);
                }
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('category_index');
            }
            else{
                    DB::beginTransaction();
                    if(App::isLocale('en')){
                        $categories->update([
                            'title' => $request->title_en
                        ]);
                    }
                    elseif(App::isLocale('ar')){
                        $categories->update([
                            'title' => $request->title_ar
                        ]);
                    }
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('category_index');
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('category_index');
        }
    }

    //* fucntion delete category
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $Category = category::findorFail($id);
            DB::beginTransaction();
                $Category->delete();
                $image = $Category->image;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
            DB::commit();
                toastr()->success(trans('message.delete'));
                return redirect()->route('category_index');
        }catch(\Exception $execption){
            DB::rollBack();
                toastr()->error(trans('message.error'));
                return redirect()->route('category_index');
        }
    }
}
