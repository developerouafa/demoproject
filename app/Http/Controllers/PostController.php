<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Post;
use App\Models\tag;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

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

    // public function getchild($id)
    // {
    //     $childrens = DB::table("childrens")->where("category_id", $id)->pluck("id", "children");
    //     return json_encode($childrens);
    // }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'title' => 'required|max:255|unique:posts,title',
    //         'body' => 'required|max:255',
    //         'Category'  => 'required',
    //         'children'  => 'required',
    //         'image' => 'required',
    //         'tag_id' => 'required',
    //     ],[
    //         'title.required' =>'Title Is Required',
    //         'title.unique' =>'Title Is Unique',
    //         'body.required' =>'Body Is Required',
    //         'Category.required' =>'Category Is Required',
    //         'children.required' =>'Child Is Required',
    //         'image.required' =>'Image Is Required',
    //         'tag_id.required' =>'Tag Is Required'
    //     ]);
    //     try{
    //         $image = $this->uploadImage($request, 'fileposts');
    //         DB::beginTransaction();
    //         Post::create([
    //             'title' => $request->title,
    //             'body' => $request->body,
    //             'category_id' => $request->Category,
    //             'children_id' => $request->children,
    //             'image' => $image
    //         ]);
    //         foreach($request->tag_id as $tag)
    //         {
    //             $post_id = Post::latest()->first()->id;
    //             $post_tag = new Post_Tag();
    //             $post_tag->post_id = $post_id;
    //             $post_tag->tag_id = $tag;
    //             $post_tag->save();
    //         }
    //         DB::commit();
    //         return redirect()->route('posts_index')->with('Success', 'Added Success');
    //     }
    //     catch(\Exception $exception){
    //         DB::rollBack();
    //         return redirect()->route('posts_index')->with('Error', 'Error');
    //     }
    // }

    // public function update(Request $request, Post $post)
    // {
    //     $this->validate($request, [
    //         'title' => 'required|max:255|unique:posts,title',
    //         'body' => 'required|max:255',
    //         'Category'  => 'required',
    //         'children'  => 'required',
    //     ],[
    //         'title.required' =>'Title Is Required',
    //         'title.unique' =>'Title Is Unique',
    //         'body.required' =>'Body Is Required',
    //         'Category.required' =>'Category Is Required',
    //         'children.required' =>'Child Is Required'
    //     ]);
    //     try{
    //         $post = $request->id;
    //         $child = Post::findOrFail($post);
    //         if($request->has('image')){
    //                 $image = $child->image;
    //                 if(!$image) abort(404);
    //                 unlink(public_path('file/'.$child->image));
    //                 $image = $this->uploadImage($request, 'fileposts');
    //                 DB::beginTransaction();
    //                 $child->update([
    //                     'title' => $request->title,
    //                     'body' => $request->body,
    //                     'category_id' => $request->Category,
    //                     'children_id' => $request->children,
    //                     'image' => $image
    //                 ]);
    //                 DB::commit();
    //                 return redirect()->route('posts_index')->with('Success','Update Success');
    //         }
    //         else{
    //                 DB::beginTransaction();
    //                 $child->update([
    //                     'title' => $request->title,
    //                     'body' => $request->body,
    //                     'category_id' => $request->Category,
    //                     'children_id' => $request->children
    //                 ]);
    //                 DB::commit();
    //                 return redirect()->route('posts_index')->with('Success','Update Success');
    //         }

    //     }catch(\Exception $execption){
    //         DB::rollBack();
    //         return redirect()->route('posts_index')->with('error','Error');
    //     }
    // }

    // public function delete(Request $request)
    // {
    //     try{
    //         $id = $request->id;
    //         $Post = Post::findorFail($id);
    //         DB::beginTransaction();
    //         $Post->delete();
    //         $image = $Post->image;
    //         if(!$image) abort(404);
    //         unlink(public_path('file/'.$Post->image));
    //         DB::commit();
    //         return redirect()->route('posts_index')->with('Success','Delete Success');
    //     }catch(\Exception $execption){
    //         DB::rollBack();
    //         return redirect()->route('posts_index')->with('error','Error');
    //     }
    // }
}
