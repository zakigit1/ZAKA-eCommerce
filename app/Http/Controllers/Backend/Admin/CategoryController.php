<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Subcategory;


use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreCategoryRequest $request)
    public function store(Request $request)
    {           
        /** Validation Part :  */
        $request->validate([

            'icon'=> ['required','not_in:empty'],
            'name'=> 'required|string|max:200|unique:categories,name',
            'status'=> 'required|boolean',
        ]);

        // return $request;
        // return dd($request->all());

        try{

            /** insert info Part in to DB :  */

            $category =Category::create([
                'icon'=>$request->icon,
                'name'=> $request->name,
                'slug'=> Str::slug($request->name),
                'status'=>$request->status
            ]);

            toastr()->success("$request->name Category Created Successfully !");
            return redirect()->route('admin.category.index');

        }catch(\Exception $e){
            
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.category.index');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);

        if(!$category){
            toastr()->error( 'category is not found!');
            return to_route('admin.category.index');
        }


        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateCategoryRequest $request, string $id)
    public function update(Request $request, string $id)
    {      
        /** Validation Part :  */

        $request->validate( [

            'icon'=> ['required','not_in:empty'],
            'name' => 'required|string|max:200|unique:categories,name,'.$id,
            'status'=> 'required|boolean',
        ]);


        // return $request;
        // dd($request->all());

        try{

            $category =Category::find($id);

            if(!$category){
                toastr()->error( 'Category is not found!');
                return to_route('admin.category.index');
            }



            /** Update info Part in to DB :  */

            // Category::where('id', $id)->update($request->except(['_token','_method','submit']));

            $category_updated =Category::where('id', $id)->update([
            'icon'=>$request->icon,
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'status'=>$request->status,
            ]);


            toastr()->success("$request->name Category Updated Successfully !");

            return redirect()->route('admin.category.index');

        }catch(\Exception $e){
            
            
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.category.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){

        try{ 

            $category = Category::find($id);


            if(!$category){
                return response(['status'=>'error','message'=>'Category is not found!']);
            }
            $category_name =$category->name;

            if(Product::where('child_category_id',$category->id)->count()>0){
                return response(['status'=>'error','message'=>"$category_name Can't Deleted Because they have products communicated with it !"]);
            }

            $homeSettings = HomePageSetting::all();

            foreach($homeSettings as $item){
                $array = json_decode($item->value ,true);
                $collection = collect($array);

                if($collection->contains('category',$category->id)){
                    return response(['status'=>'error','message'=>"$category_name Can't Deleted Because they have communication with home page settings!"]);
                }
            }


            ####### M1:
            $subcategories =Subcategory::where('category_id',$category->id)->count();

            if($subcategories>0){
                return response(['status'=>'error','message'=>"$category_name contain a Sub categories , for delete this Main category you have to delete the Sub categories first "]);

            }

            ####### M2:Relation
            // if(isset($category->subcategories)  && count($category->subcategories)>0){

            //     return response(['status'=>'error','message'=>"$category_name Can't Deleted Because they have subcategories !"]);
            // }





            //! you cant delete the category because if the category have product add another condtion for product .
            // $category->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"$category_name Category Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }



    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:categories,id',
            'status' => 'required|in:true,false',
        ]);

        $category = Category::find($request->id);

        if(!$category){
            return response(['status'=>'error','message'=>'Category is not found!']);
        }

        $category_name =$category->name;


        ### to check if category have subcategories , we can't desactive the status 
        $subcategories =Subcategory::where('category_id',$category->id)->get();

        if($subcategories->count() > 0 && $request->status != 'true'){
            return response(['status'=>'error','message'=>"$category_name contain a Sub categories ,if you want to deactive the  Main category you have to desactive the Sub categories first "]);
        }

        // // if you want to disable category
        // if ($subcategories->count() > 0 && $request->status != 'true') {
        //     $subcategories->update(['status' => 0]);
        //     foreach ($subcategories as $subcategory) {
        //         $subcategory->childcategories()->update(['status' => 0]);
        //     }
        // }

        
        $category->status = $request->status == 'true' ? 1 : 0;
         
        $category->save();

        $status =($category->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The category has been $status"]);

       
    }
}
