<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\BrandsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    use imageUploadTrait;

    const FOLDER_PATH = '/Uploads/images/';
    const FOLDER_NAME = 'brands';


    /**
     * Display a listing of the resource.
     */
    public function index(BrandsDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'logo'=>'required|image|',
            'name'=> 'required|string|max:200|unique:categories,name',
            'is_featured'=>'required|boolean',
            'status'=>'required|boolean'
        ]);
        
        // dd($request->all());

        try{

            /** Image Part START   */ 

            // ?this two raw are the same for using a const :
            // $imageName= $this->uploadImage_Trait($request,'logo',BrandController::FOLDER_PATH,BrandController::FOLDER_NAME);
            $imageName= $this->uploadImage_Trait($request,'logo',self::FOLDER_PATH,self::FOLDER_NAME);
            /** Image Part END   */ 
    
    
            $brand=Brand::create([
                'logo'=>$imageName,
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'is_featured'=>$request->is_featured,
                'status'=>$request->status
            ]);

            toastr()->success("The Brand $request->name Is Created Successfully !");
            return redirect()->route('admin.brand.index');
        }catch(\Exception $ex){
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.brand.index');
        }
        
 

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $brand=Brand::find($id);


        if(!$brand){
            // toastr()->error('Brand Not Found !');
            toastr('Brand Not Found ! ','error');
            return redirect()->route('admin.brand.index');
        }
        return view('admin.brand.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'logo'=>'nullable|image',
            'name'=> 'required|string|max:200|unique:categories,name,'.$id,
            'is_featured'=>'required|boolean',
            'status'=>'required|boolean'
        ]);
        // dd($request->all());

        try{
            DB::beginTransaction();

            $brand=Brand::find($id);


            if(!$brand){
                // toastr()->error('Brand Not Found !');
                toastr('Brand Not Found ! ','error');
                return redirect()->route('admin.brand.index');
            }
            if($request->hasFile('logo')){
    
                $old_logo =$brand->logo;
    
                $updateImage=$this->updateImage_Trait($request,'logo',BrandController::FOLDER_PATH,BrandController::FOLDER_NAME,$old_logo);
                // $updateImage=$this->updateImage_Trait($request,'logo',self::FOLDER_PATH,self::FOLDER_NAME,$old_logo);

                $update_logo =$brand->update([
                    'logo'=>$updateImage
                ]);
            }
    
    
    
            $update_brand = $brand->update([
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'is_featured'=>$request->is_featured,
                'status'=>$request->status,
            ]);

            DB::commit();
            toastr()->success("The Brand $request->name Is Updated Successfully !");
            return redirect()->route('admin.brand.index');
    
        }catch(\Exception $ex){
            DB::rollback();
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.brand.index');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){

        try{ 

            $brand = Brand::find($id);

            if(!$brand){
                toastr()->error( 'Brand is not found!');
                return to_route('admin.brand.index');
            }


            $brand_name =$brand->name;

            // ! you can't delete category if there are sub category or child category
            //? first delete the sub category
            /**
            
                if(lwla tchof ida had category 3ndha sub categories){
                    if(tchof ida sub categories 3nddah child categories )
                        $category->childcategories()->delete();
                        $category->subcategories()->delete();
                        $category->delete();
                    else{
                        $category->subcategories()->delete();
                        $category->delete();
                    }
                }else{
                 $category->delete();
                }
            */
            ####### M1:
            // $subcategories =Subcategory::where('category_id',$category->id)->count();

            // if($subcategories>0){
            //     return response(['status'=>'error','message'=>"$category_name contain a Sub categories , for delete this Main category you have to delete the Sub categories first "]);

            // }

            ####### M2:Relation
            // if(isset($category->subcategories)  && count($category->subcategories)>0){

            //     return response(['status'=>'error','message'=>"$category_name Can't Deleted Because they have subcategories !"]);
            // }

            $this->deleteImage_Trait($brand->logo);
            $brand->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"$brand_name Brand Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }



    public function change_status(Request $request)
    {
        $brand =Brand::find($request->id);

        if(!$brand){
            toastr()->error( 'Brand is not found!');
            return to_route('admin.brand.index');
        }

        $brand_name =$brand->name;


        ### to check if category have subcategories , we can't desactive the status 
        // $subcategories =Subcategory::where('category_id',$category->id)->count();

        // if($subcategories>0 && $request->status != 'true'){
        //     return response(['status'=>'error','message'=>"$category_name contain a Sub categories ,if you want to deactive the  Main category you have to desactive the Sub categories first "]);
        // }

        
        $brand->status = $request->status == 'true' ? 1 : 0;
         
        $brand->save();

        $status =($brand->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Brand has been $status"]);

       
    }
}
