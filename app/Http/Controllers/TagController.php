<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_tag;
use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    //* function index Tag
    public function index()
    {
        $tags = tag::query()->select('id', 'title')->with('post_tags')->get();
        return view('tags.tags', compact('tags'));
    }

    //* function index Tag_Post
    public function tag_posts($id)
    {
        $tag_posts = Post_tag::query()->where('tag_id', $id)->get();
        $posts = Post::query()->get();
        return view('tag_posts.tag_posts',compact('tag_posts', 'posts'));
    }

    //* function create other Tag
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'title' => 'required|max:255',
        ],[
            'title.required' =>__('messagevalidation.users.titlerequired'),
        ]);

        try{
            $exists = tag::where('name_en', '=',  $request->title)->where('name_ar', '=',  $request->titlear)->exists();
            if($exists){
                toastr()->error('Tag Is Exist');
                return redirect()->route('tags_index');
            }
            else{
                DB::beginTransaction();
                tag::create([
                    'title' => ['en' => $request->title, 'ar' => $request->titlear],
                    'name_en' => $request->title,
                    'name_ar' => $request->titlear,
                ]);
                DB::commit();
                toastr()->success(trans('message.create'));
                return redirect()->route('tags_index');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('tags_index');
        }
    }

    //* function update Tag
    public function update(Request $request)
    {
        // validations
        $this->validate($request, [
            'title' => 'required|max:255',
        ],[
            'title.required' =>'Title Is Required',
        ]);
        try{
            $tag = $request->id;
            $tags = tag::findOrFail($tag);
            $input = $request->all();
            $b_exists = tag::where('name_'.app()->getLocale().'' , '=', $input['title'])->exists();
            if($b_exists){
                toastr()->success(trans('Tag Is Exist'));
                return redirect()->route('tags_index');
            }
            else{
                DB::beginTransaction();
                $tags->update([
                    'title' => $request->title,
                    'name_'.app()->getLocale().'' => $request->title
                ]);
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('tags_index');
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('tags_index');
        }
    }

    //* function delete Tag
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            DB::beginTransaction();
            tag::findorFail($id)->delete();
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('tags_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('tags_index');
        }
    }
}
