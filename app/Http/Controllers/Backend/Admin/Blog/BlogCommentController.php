<?php

namespace App\Http\Controllers\Backend\Admin\Blog;

use App\DataTables\BlogCommentDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index(BlogCommentDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.blog-comment.index');
    }



    public function destroy(string $id){

        try{ 

            $comment = BlogComment::find($id);

            if(!$comment){
                return response(['status'=>'error','message'=>'blog comment is not found!']);
            }

 
            $comment->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"Comment Has Been Deleted Successfully !"]);

        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }
}
