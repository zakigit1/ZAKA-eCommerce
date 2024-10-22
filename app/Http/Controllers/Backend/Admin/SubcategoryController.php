<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\SubcategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\HomePageSetting;
use App\Models\Product;
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

    public function edit(string $id)
    {
        $data=[];
        // $data['categories'] = category::all();
        $data['categories'] = Category::get(['id','name']);
        $data['subcategory'] = Subcategory::find($id);

        if(!$data['subcategory']){
            toastr()->error( 'Subcategory is not found!');
            return to_route('admin.sub-category.index');
        }


        return view('admin.subcategory.edit',$data);
    }


    public function update(Request $request, string $id)
    {           
        /** Validation Part :  */
        $request->validate([

            'category'=> 'required',//category_id
            'name'=> 'required|string|max:200|unique:subcategories,name,'.$id,
            'status'=> 'required|boolean',
        ]);

        // return $request;
        // return dd($request->all());

        try{

            $subcategory =Subcategory::find($id);

            if(!$subcategory){
                toastr()->error( 'Subategory is not found!');
                return to_route('admin.sub-category.index');
            }

            /** insert info Part in to DB :  */

            $update_subcategory =$subcategory->update([
                'category_id'=>$request->category,
                'name'=> $request->name,
                'slug'=> Str::slug($request->name),
                'status'=>$request->status
            ]);
            // $subcategory =Subcategory::where('id',$id)->update([
            //     'category_id'=>$request->category,
            //     'name'=> $request->name,
            //     'slug'=> Str::slug($request->name),
            //     'status'=>$request->status
            // ]);

           
            toastr()->success("$request->name Subcategory Updated Successfully !");
            return redirect()->route('admin.sub-category.index');

        }catch(\Exception $e){
            
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.sub-category.index');
        }
    }


    public function destroy(string $id){

        try{ 

            $subcategory = Subcategory::find($id);



            if(!$subcategory){
                return response(['status'=>'error','message'=>'Sub Category is not found!']);
            }
            $subcategory_name =$subcategory->name;

            if(Product::where('child_category_id',$subcategory->id)->count()>0){
                return response(['status'=>'error','message'=>"$subcategory_name Can't Deleted Because they have products communicated with it !"]);
            }

            $homeSettings = HomePageSetting::all();

            foreach($homeSettings as $item){
                $array = json_decode($item->value ,true);
                $collection = collect($array);

                if($collection->contains('sub_category',$subcategory->id)){
                    return response(['status'=>'error','message'=>"$subcategory_name Can't Deleted Because they have communication with home page settings!"]);
                }
            }


            ####### M1:
            $childcategories =Childcategory::where('sub_category_id',$subcategory->id)->count();

            if($childcategories>0){
                return response(['status'=>'error','message'=>"$subcategory_name contain a child categories , for delete this sub category you have to delete the child categories first "]);

            }

            ####### M2:
            // if(isset($subcategory->childcategories)  && count($subcategory->childcategories)>0){

            //     return response(['status'=>'error','message'=>"$subcategory_name Can't Deleted Becaus they have childcategories !"]);
            // }



            // $subcategory->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"$subcategory_name Category Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }



    public function change_status(Request $request)
    {
        $subcategory =Subcategory::find($request->id);

        if(!$subcategory){
            return response(['status'=>'error','message'=>'Sub Category is not found!']);
        }

        $subcategory_name =$subcategory->name;

        ### to check if category have subcategories , we can't desactive the status 
        $childcategories =Childcategory::where('sub_category_id',$subcategory->id)->get();

        if($childcategories->count() >0 && $request->status != 'true'){
            return response(['status'=>'error','message'=>"$subcategory_name contain a child categories ,if you want to deactive the sub category you have to desactive the Sub categories first "]);
        }
        
        // if($childcategories->count()>0 && $request->status != 'true'){
        //     $childcategories->update(['status' => 0]);
        // }
        
        

        //! also for this when you desactivate the subcategory , the child are desactivate also 
        $subcategory->status = $request->status == 'true' ? 1 : 0;
         
        $subcategory->save();

        $status =($subcategory->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Subcategory has been $status"]);

       
    }
}
