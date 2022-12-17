<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    Use UploadImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $categoriesindex = category::query()->select('id', 'title', 'status', 'image')->with('category')->parent()->get();
        return view('categories.categories', compact('categoriesindex'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|unique:categories,title',
            // 'titlear' => 'required|max:255|unique:categories,title',
            'image' => 'required',
        ],[
            'title.required' =>__('messagevalidation.users.titlerequired'),
            'title.unique' =>__('messagevalidation.users.titlunique'),
            'image.required' =>__('messagevalidation.users.imagerequired'),
        ]);
        try{
            $exists = category::where('name', '=',  $request->title)->exists();
            if($exists){
                toastr()->error('Category Is Exist');
                return redirect()->route('category_index');
            }
            else{
                $image = $this->uploadImagecategory($request, 'filecategory');
                DB::beginTransaction();
                category::create([
                    // 'title' => $request->title,
                    'title' => ['en' => $request->title, 'ar' => $request->titlear],
                    'status' => 0,
                    'image' => $image,
                    'name' => $request->title
                ]);
                DB::commit();
                toastr()->success(trans('message.create'));
                return redirect()->route('category_index');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('category_index');
        }
    }

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

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ],[
            'title.required' =>__('messagevalidation.users.titlerequired')
        ]);
        try{
            $category = $request->id;
            $categories = category::findOrFail($category);
            if($request->has('image')){
                $input = $request->all();
                $b_exists = category::where('name', '=', $input['title'])->exists();
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
                        'name' => $request->title
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('category_index');
                }
            }
            else{
                $input = $request->all();
                $b_exists = category::where('name', '=', $input['title'])->exists();
                if($b_exists){
                    toastr()->error('This Is Exist');
                    return redirect()->route('category_index');
                }
                else{
                    DB::beginTransaction();
                    $categories->update([
                        'title' => $request->title,
                        'name' => $request->title
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
