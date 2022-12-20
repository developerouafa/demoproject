<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Post;
use App\Models\Post_tag;
use App\Models\tag;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        $childrens = category::query()->select('id', 'title', 'image', 'status','parent_id')->with('subcategories')->child()->get();
        $categories = category::query()->select('id', 'title', 'image', 'status','parent_id')->with('category')->parent()->get();
        $posts = Post::query()->select('id', 'title','body', 'category_id', 'parent_id', 'image')->with('category')->with('subcategories')->get();
        $tags = tag::query()->select('id', 'title')->get();
        return view('posts.posts', compact('posts', 'categories', 'childrens', 'tags'));
    }

    public function create()
    {
        $categories = category::query()->select('id', 'title', 'image', 'status','parent_id')->with('category')->parent()->get();
        $childrens = category::query()->select('id', 'title', 'image', 'status','parent_id')->with('subcategories')->child()->get();
        $tags = tag::query()->select('id', 'title')->get();
        return view('posts.postscreate', compact('categories', 'childrens', 'tags'));
    }

    public function getchild($id)
    {
        $childrens = DB::table("categories")->where("parent_id", $id)->pluck('id', 'name_'.app()->getLocale().'');
        return json_encode($childrens);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'title_ar' => 'required',
            'body' => 'required',
            'body_ar' => 'required',
            'image' => 'required',
            'Category'  => 'required',
            'children'  => 'required',
        ],[
            'title.required' =>__('messagevalidation.users.titleenrequired'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'body.required' =>__('messagevalidation.users.bodyenrequired'),
            'body_ar.required' =>__('messagevalidation.users.bodyarrequired'),
            'image.required' =>__('messagevalidation.users.imagerequired'),
            'Category.required' =>__('messagevalidation.users.categoryrequired'),
            'children.required' =>__('messagevalidation.users.childrenrequired'),
        ]);
        try{
            if($request->has('image')){
                $image = $this->uploadImageposts($request, 'fileposts');
                DB::beginTransaction();
                Post::create([
                    'title' => ['en' => $request->title, 'ar' => $request->title_ar],
                    'body' => ['en' => $request->body, 'ar' => $request->body_ar],
                    'category_id' => $request->Category,
                    'parent_id' => $request->children,
                    'image' => $image,
                    'name_en' => $request->title,
                    'name_ar' => $request->title_ar
                ]);
                foreach($request->tag_id as $tag)
                {
                    $post_id = Post::latest()->first()->id;
                    $post_tag = new Post_tag();
                    $post_tag->post_id = $post_id;
                    $post_tag->tag_id = $tag;
                    $post_tag->save();
                }
                DB::commit();
                toastr()->success(trans('message.create'));
                return redirect()->route('posts_index');
            }
            else{
                toastr()->error(trans('messagevalidation.users.imagerequired'));
                return redirect()->route('posts_index');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('posts_index');
        }
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required'
        ],[
            'title.required' =>__('messagevalidation.users.titlerequired')
        ]);
        try{
            $post = $request->id;
            $posts = Post::findOrFail($post);
            if($request->hasFile('image')){
                $input = $request->all();
                $b_exists = Post::where('name_'.app()->getLocale().'' , '=', $input['title'])->exists();
                if($b_exists){
                    $image = $posts->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImageposts($request, 'fileposts');
                    DB::beginTransaction();
                    $posts->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('posts_index');
                }
                else{
                    $image = $posts->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImageposts($request, 'fileposts');
                    DB::beginTransaction();
                    $posts->update([
                        'title' => $request->title,
                        'body' => $request->body,
                        'category_id' => $request->Category,
                        'parent_id' => $request->children,
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('posts_index');
                }
            }
            else{
                $input = $request->all();
                $b_exists = Post::where('name_'.app()->getLocale().'' , '=', $input['title'])->exists();
                if($b_exists){
                    toastr()->error(trans('message.thisexist'));
                    return redirect()->route('posts_index');
                }
                else{
                    DB::beginTransaction();
                    $posts->update([
                        'title' => $request->title,
                        'body' => $request->body,
                        'category_id' => $request->Category,
                        'parent_id' => $request->children,
                        'name_'.app()->getLocale().'' => $request->title
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('posts_index');
                }
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('posts_index');
        }
    }

    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $Post = Post::findorFail($id);
            DB::beginTransaction();
                $Post->delete();
                $image = $Post->image;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$Post->image));
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('posts_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('posts_index');
        }
    }

    // public function deleteallpost()
    // {
    //     Post::truncate();
    //     return redirect()->back();
    // }
}
