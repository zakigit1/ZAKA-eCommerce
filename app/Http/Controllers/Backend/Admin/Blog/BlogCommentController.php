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
                toastr()->error( 'Blog Comment is not found!');
                return to_route('admin.blog-comment.index');
            }

 
            $comment->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"Comment Has Been Deleted Successfully !"]);

        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }
}
