<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildrenCatController extends Controller
{
    Use UploadImageTrait;
    public function index()
    {
        $childrens = category::query()->select('id', 'title', 'image', 'status','parent_id')->with('subcategories')->child()->get();
        $categories = category::query()->select('id', 'title', 'image', 'status','parent_id')->with('category')->parent()->get();
        return view('childrens.childrens', compact('childrens', 'categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'childrenen' => 'required|max:255',
            'childrenar' => 'required|max:255',
            'image' => 'required',
        ],[
            'childrenen.required' =>__('messagevalidation.users.titlearrequired'),
            'childrenar.required' =>__('messagevalidation.users.titleenrequired'),
            'image.required' =>__('messagevalidation.users.imagerequired'),
        ]);
        try{
                $image = $this->uploadImageChildrenCat($request, 'fileChildren');
                $input = $request->all();
                $b_exists = category::where('name', '=', $input['childrenen'])->where('parent_id', '=', $input['category_id'])->exists();
                if($b_exists){
                    toastr()->error('Children Is Exist');
                    return redirect()->route('childcat_index');
                }
                else{
                    DB::beginTransaction();
                    category::create([
                        'title' => ['en' => $request->childrenen, 'ar' => $request->childrenar],
                        'parent_id' => $request->category_id,
                        'image' => $image,
                        'name' => $request->childrenen
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.create'));
                    return redirect()->route('childcat_index');
                }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('childcat_index');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'children' => 'required|max:255',
        ],[
            'children.required' =>__('messagevalidation.users.titlerequiredd'),
        ]);
        try{
            $children = $request->id;
            $child = category::findOrFail($children);
            if($request->has('image')){
                $input = $request->all();
                $b_exists = category::where('name', '=', $input['children'])->where('parent_id', '=', $input['category_id'])->exists();
                if($b_exists){
                    $image = $child->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImageChildrenCat($request, 'fileChildren');
                    DB::beginTransaction();
                    $child->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('childcat_index');
                }
                else{
                    $image = $child->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImageChildrenCat($request, 'fileChildren');
                    DB::beginTransaction();
                    $child->update([
                        'title' => $request->children,
                        'parent_id' => $request->category_id,
                        'image' => $image,
                        'name' => $request->children
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('childcat_index');
                }
            }
            else{
                $input = $request->all();
                $b_exists = category::where('name', '=', $input['children'])->where('parent_id', '=', $input['category_id'])->exists();
                if($b_exists){
                    toastr()->error('This Is Exist');
                    return redirect()->route('childcat_index');
                }
                else{
                    DB::beginTransaction();
                    $child->update([
                        'title' => $request->children,
                        'parent_id' => $request->category_id,
                        'name' => $request->children
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('childcat_index');
                }
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('childcat_index');
        }
    }

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
