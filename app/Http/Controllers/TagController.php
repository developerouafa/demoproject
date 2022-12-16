<?php

namespace App\Http\Controllers;

use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function tag_testing(){
        return tag::get();
    }

    public function index()
    {
        // $tags = tag::query()->select('id', 'title')->with('post_tags')->get();
        $tags = tag::query()->select('id', 'title')->get();
        return view('tags.tags', compact('tags'));
    }

    // public function tag_posts($id)
    // {
    //     $tag_posts = Post_tag::query()->where('tag_id', $id)->get();
    //     $posts = Post::query()->get();
    //     return view('tag_posts.tag_posts',compact('tag_posts', 'posts'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|unique:tags,title',
        ],[
            'title.required' =>__('messagevalidation.users.titlerequired'),
            'title.unique' =>__('messagevalidation.users.titlunique'),
        ]);

        try{
            DB::beginTransaction();
            tag::create([
                'title' => $request->title,
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


    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ],[
            'title.required' =>'Title Is Required',
        ]);
        try{
            $tag = $request->id;
            $tags = tag::findOrFail($tag);
            $input = $request->all();
            $b_exists = tag::where('title', '=', $input['title'])->exists();
            if($b_exists){
                toastr()->success(trans('Tag Is Exist'));
                return redirect()->route('tags_index');
            }
            else{
                DB::beginTransaction();
                $tags->update([
                    'title' => $request->title
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
