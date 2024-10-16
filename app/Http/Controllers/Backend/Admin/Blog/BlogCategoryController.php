<?php

namespace App\Http\Controllers\Backend\Admin\Blog;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.blog-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $request->validate([
            'name' => 'required|string|max:200|unique:blog_categories,name',
            'status'=> 'required|boolean',
        ],[
            'name.unique' => 'Blog Category Already Exists !'
        ]);

        // dd($request->all());

        $blogCategory = New BlogCategory();

        $blogCategory->name = $request->name;
        $blogCategory->slug = Str::slug($request->name);
        $blogCategory->status = $request->status;
        
        $blogCategory->save();

        toastr('Blog Category Has Been Created Successfully!','success','Success');
        return redirect()->route('admin.blog-category.index');


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $blogCategory = BlogCategory::find($id);

        if(!$blogCategory){
            toastr('Blog Category Not Found !','error','Error');
            return redirect()->route('admin.blog-category.index');
        }


        return view('admin.blog.blog-category.edit',compact('blogCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:200|unique:blog_categories,name,'.$id,
            'status'=> 'required|boolean',
        ],[
            'name.unique' => 'Blog Category Already Exists !'
        ]);

    // dd($request->all());
        
        $blogCategory = BlogCategory::find($id);

        if(!$blogCategory){
            toastr('Blog Category Not Found !','error','Error');
            return redirect()->route('admin.blog-category.index');
        }


        $blogCategory->name = $request->name;
        $blogCategory->slug = Str::slug($request->name);
        $blogCategory->status = $request->status;

        $blogCategory->save();

        toastr('Blog Category Has Been Updated Successfully!','success','Success');
        return redirect()->route('admin.blog-category.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){

        try{ 

            $blogCategory = BlogCategory::find($id);

            if(!$blogCategory){
                toastr()->error( 'Blog Category is not found!');
                return to_route('admin.blog-category.index');
            }


            $blog_category_name = $blogCategory->name;


            //!  if the blog Category have Blogs you cant deleted add condition for it 

            if(isset($blogCategory->blogs) && count($blogCategory->blogs) > 0){

                return response(['status'=>'error','message'=>"$blog_category_name contain a Blog(s) , for delete this Blog category you have to delete the blog(s) first "]);
            }


            $blogCategory->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"$blog_category_name Blog Category Deleted Successfully !"]);

        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    /**
     * Change Status the specified resource from storage.
    */
    public function change_status(Request $request)
    {
        $blogCategory =BlogCategory::find($request->id);

        if(!$blogCategory){
            toastr()->error( 'Blog Category is not found!');
            return to_route('admin.blog-category.index');
        }

        $blog_category_name =$blogCategory->name;


        ### to check if category have subcategories , we can't desactive the status 
        $blog = Blog::where('blog_category_id',$blogCategory->id)->count();

        if( $blog > 0 && $request->status != 'true'){
            return response(['status'=>'error','message'=>"$blog_category_name contain a blog(s) ,if you want to deactive the  blog category you have to desactive the blog(s) first "]);
        }

        
        $blogCategory->status = $request->status == 'true' ? 1 : 0;
         
        $blogCategory->save();

        $status =($blogCategory->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The $blog_category_name blog category has been $status"]);

       
    }
}
