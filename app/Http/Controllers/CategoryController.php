<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //* Page UploadImageTrait inside it function Image
    Use UploadImageTrait;

    //* function index Catgeory
    public function index()
    {
        $categoriesindex = category::query()->select('id', 'title', 'status', 'image')->with('category')->parent()->get();
        return view('categories.categories', compact('categoriesindex'));
    }

    //* function create other category
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'title_en' => 'required',
            'title_ar' => 'required',
        ],[
            'title_en.required' =>__('messagevalidation.users.titleenrequired'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
        ]);
        try{
            //Added photo
            if($request->has('image')){
                $exists = category::where('name_en', '=',  $request->title_en)->where('name_ar', '=',  $request->title_ar)->exists();
                if($exists){
                    toastr()->error('Category Is Exist');
                    return redirect()->route('category_index');
                }
                else{
                    $image = $this->uploadImagecategory($request, 'filecategory');
                    DB::beginTransaction();
                    category::create([
                        'title' => ['en' => $request->title_en, 'ar' => $request->title_ar],
                        'status' => 0,
                        'image' => $image,
                        'name_en' => $request->title_en,
                        'name_ar' => $request->title_ar
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.create'));
                    return redirect()->route('category_index');
                }
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
            'title' => 'required',
        ],[
            'title.required' =>__('messagevalidation.users.titlerequired')
        ]);
        try{
            $category = $request->id;
            $categories = category::findOrFail($category);
            if($request->has('image')){
                $input = $request->all();
                $b_exists = category::where('name_'.app()->getLocale().'' , '=', $input['title'])->exists();
                if($b_exists){
                    $image = $categories->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImagecategory($request, 'filecategory');
                    DB::beginTransaction();
                    $categories->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('category_index');
                }
                else{
                    $image = $categories->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImagecategory($request, 'filecategory');
                    DB::beginTransaction();
                    $categories->update([
                        'title' => $request->title,
                        'image' => $image,
                        'name_'.app()->getLocale().'' => $request->title
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('category_index');
                }
            }
            else{
                $input = $request->all();
                $b_exists = category::where('name_'.app()->getLocale().'' , '=', $input['title'])->exists();
                if($b_exists){
                    toastr()->error(trans('message.thisexist'));
                    return redirect()->route('category_index');
                }
                else{
                    DB::beginTransaction();
                    $categories->update([
                        'title' => $request->title,
                        'name_'.app()->getLocale().'' => $request->title
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('category_index');
                }
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
