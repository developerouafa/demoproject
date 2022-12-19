<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_tag;
use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostTagController extends Controller
{
    public function index($id)
    {
        $post = Post::where('id',$id)->firstOrFail();
        $post_tag  = Post_tag::where('post_id',$id)->get();
        $post_tagupdate  = Post_tag::where('post_id',$id)->first();
        $tags = tag::query()->get();
        return view('post_tag.post_tag',compact('post','post_tag','post_tagupdate','tags'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'tag_id' => 'required|max:255',
        ],[
            'tag_id.required' =>__('messagevalidation.users.titlerequired'),
        ]);
        try{
                $input = $request->all();
                $b_exists = Post_Tag::where('post_id', '=', $input['post_id'])->where('tag_id', '=', $input['tag_id'])->exists();
                if($b_exists){
                    toastr()->error(trans('message.thisexist'));
                    return redirect()->back();
                }
                else{
                    DB::beginTransaction();
                    Post_Tag::create([
                        'post_id' => $request->post_id,
                        'tag_id' => $request->tag_id
                    ]);
                    DB::commit();
                    toastr()->success(trans('message.create'));
                    return redirect()->back();
                }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();
            Post_Tag::findorFail($id)->delete();
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }
}
