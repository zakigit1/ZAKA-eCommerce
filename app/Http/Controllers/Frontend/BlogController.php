<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function blogDetails(string $slug){

        $blog = Blog::with(['blogcategory','user','comments'])
            ->where(['slug' => $slug , 'status' => 1])
            ->first();

        if(!$blog){
            return abort(404);
        }

        $blogCategories = BlogCategory::where('status', 1)->get(['id','name','slug']);

        
        $blogs = Blog::with('blogcategory')
            ->where('slug', '!=', $slug)
            ->where('status',1)
            ->orderBy('created_at','DESC')
            ->take(5)
            ->get();
        
        $related_blogs = Blog::with('blogcategory')
            ->where('slug', '!=', $slug)
            ->where('status',1)
            ->where('blog_category_id', $blog->blog_category_id)
            ->orderBy('id','DESC')
            ->take(15)
            ->get();
        
        
        $comments = $blog->comments()->paginate(20);

        // dd($comments);

        return view('Frontend.store.pages.blog.blog-details',compact('blog','blogCategories','blogs','comments','related_blogs'));
    }



    public function blogComment(Request $request){

        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'comment' =>'required|string|max:1000'
        ],[
            'blog_id.exists' =>'Blog Not Found!'
        ]);

        // dd($request->all());


        /**  this  for check if how made the blog is make the comment  */

        $blog = Blog::find($request->blog_id);

        if(!$blog){
            toastr('Something is wrong !','error','Error');
            return redirect()->back();
        }
        

        if($blog->user_id == Auth::user()->id){ // Because we are remove the replay from the the comment 
            toastr('You Can\'t Comment To Your Self !','error','Error');
            return redirect()->back();
        }


        /** Check if user is comment already (also because we remove the repaly  so user can comment just one time) */

        $comment = BlogComment::where(['user_id' => Auth::user()->id ,'blog_id' => $blog->id])->first();

        if($comment){
            toastr('You are already commented for this post !','error','Error');
            return redirect()->back();
        }

        // Add the Comment
        $comment = New BlogComment();
        $comment->user_id = Auth::user()->id ;
        $comment->blog_id = $request->blog_id;
        $comment->comment = $request->comment ;
        $comment->save();

        toastr('Comment Added Successfully!');
        return redirect()->back();

    }


    public function blogIndex(Request $request){

        if($request->has('search')){

            $blogs = Blog::with('blogcategory')
                ->where('title','like','%'.$request->search.'%')    
                ->orWhere('description','like','%'.$request->search.'%')
                ->where('status',1)
                ->orderBy('id','DESC')
                ->paginate(8);

        }elseif($request->has('blogCategory')){
            $blogCategory = BlogCategory::where('slug',$request->blogCategory)->where('status', 1)->firstOrFail();
 
            $blogs = Blog::with('blogcategory')
                ->where('blog_category_id',$blogCategory->id)
                ->where('status',1)
                ->orderBy('id','DESC')
                ->paginate(8);
        }else{

            $blogs = Blog::with('blogcategory')
                ->where('status',1)
                ->orderBy('id','DESC')
                ->paginate(8);
        }

        // dd($blogs);
        return view('Frontend.store.pages.blog.index',compact('blogs'));
    }
}
