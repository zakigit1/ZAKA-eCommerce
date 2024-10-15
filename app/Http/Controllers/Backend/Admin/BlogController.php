<?php

namespace App\Http\Controllers\Backend\Admin;


use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    use imageUploadTrait;

    const FOLDER_PATH = '/Uploads/images/';
    const FOLDER_NAME = 'blogs';



    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogCategories = BlogCategory::where('status', 1)->get(['id','name']);
        return view('admin.blog.create',compact('blogCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:3000',
            'title' => 'required|max:200|unique:blogs,title',
            'blog_category' => 'required',
            'description' => 'required',
            'seo_title'=>'nullable|max:200',
            'seo_description'=>'nullable|max:250',
            'status' => 'required',
        ]);

        // dd($request->all());

        try{

            $imageName = $this->uploadImage_Trait($request,'image',self::FOLDER_PATH,BlogController::FOLDER_NAME);

            $blog= Blog::create([
                'image' => $imageName,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'user_id' => Auth::user()->id,
                'blog_category_id' => $request->blog_category,
                'description' => $request->description,

                'seo_title' => $request->seo_title,
                'seo_description' => $request->seo_description,

                'status' => $request->status,
            ]);

            
            toastr('Blog has been created successfully','success');

            return to_route('admin.blog.index');
        }catch(\Exception $ex){

            // toastr($ex->getMessage(),'error');
            toastr('Blog has not been created successfully','error');
            return to_route('admin.blog.index');
        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);

        if(!$blog){
            toastr('Blog Not Found !','error','Error');
            return redirect()->route('admin.blog.index');
        }

        $blogCategories = BlogCategory::where('status', 1)->get(['id','name']);

        return view('admin.blog.edit',compact('blog','blogCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'image|max:3000',
            'title' => 'required|max:200|unique:blogs,title,'.$id,
            'blog_category' => 'required',
            'description' => 'required',
            'seo_title'=>'nullable|max:200',
            'seo_description'=>'nullable|max:250',
            'status' => 'required',
        ]);

        // dd($request->all());

        try{

            DB::beginTransaction();

            $blog = Blog::find($id);

            if(!$blog){
                toastr()->error( 'Blog is not found!');
                return to_route('admin.blog.index');
            }


            if($request->hasFile('image')){
                
                $old_image = $blog->image;
                $imageName=$this->updateImage_Trait($request,'image',self::FOLDER_PATH,self::FOLDER_NAME,$old_image);

                
                $blog->update([
                    'image'=>$imageName,
                ]);
            }

            $update_blog = $blog->update([
             
                'title' => $request->title,

                'slug' => Str::slug($request->title),
                
                'blog_category_id' => $request->blog_category,

                'description' => $request->description,

                'seo_title' => $request->seo_title,

                'seo_description' => $request->seo_description,

                'status' => $request->status,
            ]);

            DB::commit();
            toastr('Blog has been updated successfully','success','Success');

            return to_route('admin.blog.index');
            // return redirect()->back();
        }catch(\Exception $ex){

            DB::rollback();
            // toastr($ex->getMessage(),'error');
            toastr('Blog has not been updated successfully','error');
            return to_route('admin.blog.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 
            $blog = Blog::find($id);

            if(!$blog){
                toastr()->error( 'Product is not found!');
                return to_route('admin.blog.index');
            }

            $blog_title =$blog->title;

            //********************   Delete Blog the image    ******************** */
            
            $this->deleteImage_Trait($blog->image);
            
               
            $blog->delete();


            // we are using ajax : 
            return response(['status'=>'success','message'=>"$blog_title Blog Deleted Successfully !"]);
        }catch(\Exception $e){
            // return response(['status'=>'error','message'=>$e->getMessage() ]);
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    /**
     * Change Status the specified resource from storage.
    */
    public function change_status(Request $request)
    {
        $blog =Blog::find($request->id);

        if(!$blog){
            toastr()->error( 'Blog is not found!');
            return to_route('admin.blog.index');
        }

       
        $blog->status = $request->status == 'true' ? 1 : 0;
         
        $blog->save();

        $status =($blog->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Blog has been $status"]);

       
    }
}
