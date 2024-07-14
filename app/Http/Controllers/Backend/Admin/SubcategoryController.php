<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\SubcategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index(SubcategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.subcategory.index');
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategory.create',compact('categories'));
        
    }



    public function store(Request $request)
    {           
        /** Validation Part :  */
        $request->validate([

            'category'=> 'required',
            'name'=> 'required|string|max:200|unique:subcategories,name',
            'status'=> 'required|boolean',
        ]);

        // return $request;
        // return dd($request->all());

        try{

            /** insert info Part in to DB :  */

            $category =Subcategory::create([
                'category_id'=>$request->category,
                'name'=> $request->name,
                'slug'=> Str::slug($request->name),
                'status'=>$request->status
            ]);

            toastr()->success("$request->name Subcategory Created Successfully !");
            return redirect()->route('admin.sub-category.index');

        }catch(\Exception $e){
            
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.sub-category.index');
        }
    }








    public function change_status(Request $request)
    {
        $category =Subcategory::find($request->id);

        if(!$category){
            toastr()->error( 'Subcategory is not found!');
            return to_route('admin.sub-category.index');
        }

        $category->status = $request->status == 'true' ? 1 : 0;
         
        $category->save();

        $status =($category->status == 1) ? 'activated' : 'deactivated';

        return response(['message'=>"The category has been $status"]);

       
    }
}
