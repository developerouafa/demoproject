<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_tag;
use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    //* function index Tag
    public function index()
    {
        $tags = tag::query()->selectags()->with('post_tags')->get();
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
            'title_en' => 'required|unique:tags,title->en',
            'title_ar' => 'required|unique:tags,title->ar',
        ],[
            'title_en.required' =>__('messagevalidation.users.titleenrequired'),
            'title_en.unique' =>__('messagevalidation.users.titleaddenunique'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'title_ar.unique' =>__('messagevalidation.users.titleaddarunique'),
        ]);
        try{
            DB::beginTransaction();
            tag::create([
                'title' => ['en' => $request->title_en, 'ar' => $request->title_ar]
            ]);
            DB::commit();
            toastr()->success(trans('message.create'));
            return redirect()->route('tags_index');
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
            'title_'.app()->getLocale() => 'required|unique:tags,title->'.app()->getLocale().','.$request->id,
        ],[
            'title_'.app()->getLocale().'.required' =>__('messagevalidation.users.titlerequired'),
            'title_'.app()->getLocale().'.unique' =>__('messagevalidation.users.titlunique')
        ]);
        try{
            $tag = $request->id;
            $tags = tag::findOrFail($tag);
                DB::beginTransaction();
                if(App::isLocale('en')){
                    $tags->update([
                        'title' => $request->title_en
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $tags->update([
                        'title' => $request->title_er
                    ]);
                }
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('tags_index');
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
