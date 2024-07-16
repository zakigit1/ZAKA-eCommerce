<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\ChildcategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildcategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.childcategory.index');
    }


    public function create()
    {
        $categories = Category::all(['id','name']);
        return view('admin.childcategory.create',compact('categories'));
        
    }

    public function get_subcategories(Request $request){

        $subcategories = Subcategory::where('category_id',$request->id)->active()->get(['id','name']);
        // $subcategories = Subcategory::where('category_id',$request->id)->active()->get();

        return $subcategories;

    }



    public function store(Request $request)
    {           
        /** Validation Part :  */
        $request->validate([

            'category'=> 'required',
            'subcategory'=> 'required',
            'name'=> 'required|string|max:200|unique:subcategories,name',
            'status'=> 'required|boolean',
        ]);

        // return $request;
        // return dd($request->all());

        try{

            /** insert info Part in to DB :  */

            $category =Childcategory::create([
                'category_id'=>$request->category,
                'sub_category_id'=>$request->subcategory,
                'name'=> $request->name,
                'slug'=> Str::slug($request->name),
                'status'=>$request->status
            ]);

            toastr()->success("$request->name Childcategory Created Successfully !");
            return redirect()->route('admin.child-category.index');

        }catch(\Exception $e){
            
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.child-category.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[];
        
        $data['childcategory'] = Childcategory::find($id);
        $data['categories'] = Category::get(['id','name']);
        $data['subcategories'] = Subcategory::where('category_id',$data['childcategory']->category_id)->get(['id','name']);
       



        if(!$data['childcategory']){
            toastr()->error( 'Childcategory is not found!');
            return to_route('admin.sub-category.index');
        }


        return view('admin.childcategory.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'category'=> 'required',//category_id
            'subcategory'=> 'required',//category_id
            'name'=> 'required|string|max:200|unique:subcategories,name,'.$id,
            'status'=> 'required|boolean',
        ]);

        // return $request;
        // return dd($request->all());

        try{

            $childcategory =Childcategory::find($id);

            if(!$childcategory){
                toastr()->error( 'Subategory is not found!');
                return to_route('admin.sub-category.index');
            }

            /** insert info Part in to DB :  */

            $update_childcategory =$childcategory->update([
                'category_id'=>$request->category,
                'sub_category_id'=>$request->subcategory,
                'name'=> $request->name,
                'slug'=> Str::slug($request->name),
                'status'=>$request->status
            ]);
            // $childcategory =Childcategory::where('id',$id)->update([
            //     'category_id'=>$request->category,
            //     'name'=> $request->name,
            //     'slug'=> Str::slug($request->name),
            //     'status'=>$request->status
            // ]);

           
            toastr()->success("$request->name Childcategory Updated Successfully !");
            return redirect()->route('admin.child-category.index');

        }catch(\Exception $e){
            
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.child-category.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){

        try{ 

            $childcategory = Childcategory::find($id);

            if(!$childcategory){
                toastr()->error( 'Child Category is not found!');
                return to_route('admin.child-category.index');
            }

            $childcategory_name =$childcategory->name;


            $childcategory->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"$childcategory_name Child Category Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function change_status(Request $request)
    {
        $childcategory =Childcategory::find($request->id);

        if(!$childcategory){
            toastr()->error( 'Child Category is not found!');
            return to_route('admin.child-category.index');
        }

       
        $childcategory->status = $request->status == 'true' ? 1 : 0;
         
        $childcategory->save();

        $status =($childcategory->status == 1) ? 'activated' : 'deactivated';

        return response(['message'=>"The $childcategory->name has been $status"]);

       
    }
}
