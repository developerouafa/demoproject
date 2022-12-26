<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ChildrenCatController extends Controller
{
    //* Page UploadImageTrait inside it function Image
    Use UploadImageTrait;

    //* function index Catgeory
    public function index()
    {
        $childrens = category::query()->selectchildrens()->withchildrens()->child()->get();
        $categories = category::query()->selectcategories()->Withcategories()->parent()->get();
        return view('childrens.childrens', compact('childrens', 'categories'));
    }

    //* function create other category
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'title_en' => 'required|unique:categories,title->en',
            'title_ar' => 'required|unique:categories,title->ar',
            'image' => 'required',
        ],[
            'title_en.required' =>__('messagevalidation.users.titleenrequired'),
            'title_en.unique' =>__('messagevalidation.users.titleaddenunique'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'title_ar.unique' =>__('messagevalidation.users.titleaddarunique'),
            'image.required' =>__('messagevalidation.users.imagerequired'),
        ]);
        try{
            //Added photo
            if($request->has('image')){
                $image = $this->uploadImageChildrenCat($request, 'fileChildren');
                    DB::beginTransaction();
                    category::create([
                        'title' => ['en' => $request->title_en, 'ar' => $request->title_ar],
                        'parent_id' => $request->category_id,
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.create'));
                    return redirect()->route('childcat_index');
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
            return redirect()->route('childcat_index');
        }
    }

    //* function update children
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
            $children = $request->id;
            $child = category::findOrFail($children);
            if($request->has('image')){
                $image = $child->image;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
                $image = $this->uploadImageChildrenCat($request, 'fileChildren');
                DB::beginTransaction();
                if(App::isLocale('en')){
                    $child->update([
                        'title' => $request->title_en,
                        'parent_id' => $request->category_id,
                        'image' => $image
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $child->update([
                        'title' => $request->title_ar,
                        'parent_id' => $request->category_id,
                        'image' => $image
                    ]);
                }
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('childcat_index');
            }
            else{
                DB::beginTransaction();
                if(App::isLocale('en')){
                    $child->update([
                        'title' => $request->title_en,
                        'parent_id' => $request->category_id
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $child->update([
                        'title' => $request->title_ar,
                        'parent_id' => $request->category_id
                    ]);
                }
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('childcat_index');
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('childcat_index');
        }
    }

    //* delete children
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $children = category::findorFail($id);
            DB::beginTransaction();
                $children->delete();
                $image = $children->image;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('childcat_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('childcat_index');
        }
    }
}
