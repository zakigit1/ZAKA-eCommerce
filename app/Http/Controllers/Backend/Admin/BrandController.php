<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\BrandsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        try{
            $request->validate([
                'logo'=>'required|image',
                'name'=> 'required|string|max:200|unique:brands,name',
                'is_featured'=>'required|boolean',
                'status'=>'required|boolean'
            ]);

            // dd($request->all());

        

            /** Image Part START   */

            // ?this two raw are the same for using a const :
            // $imageName= $this->uploadImage_Trait($request,'logo',BrandController::FOLDER_PATH,BrandController::FOLDER_NAME);
            // $imageName= $this->uploadImage_Trait($request,'logo',self::FOLDER_PATH,self::FOLDER_NAME);
            /** Image Part END   */


            $imageName = uploadImageResizeWithoutBg2($request->logo, self::FOLDER_PATH, self::FOLDER_NAME,true,true);



            Brand::create([
                'logo'=>$imageName,
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'is_featured'=>$request->is_featured,
                'status'=>$request->status
            ]);

            toastr()->success("The Brand $request->name Is Created Successfully !");
            return redirect()->route('admin.brand.index');

        } catch (ValidationException $e) {
            toastr($e->getMessage(),'error','Error');
            return redirect()->back();

        }catch(\Exception $ex){
            toastr()->error( $ex->getMessage());
            return redirect()->back();;
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
        
        try{
            $request->validate([
                'logo'=>'nullable|image',
                'name'=> 'required|string|max:200|unique:brands,name,'.$id,
                'is_featured'=>'required|boolean',
                'status'=>'required|boolean'
            ]);
            // dd($request->all());

            DB::beginTransaction();

            $brand=Brand::find($id);


            if(!$brand){
                // toastr()->error('Brand Not Found !');
                toastr('Brand Not Found ! ','error');
                return redirect()->route('admin.brand.index');
            }
            if($request->hasFile('logo')){

                $old_logo =$brand->logo;

                
                // $updateImage = $this->updateImage_Trait($request,'logo',BrandController::FOLDER_PATH,BrandController::FOLDER_NAME,$old_logo);
                
                // $updateImage=$this->updateImage_Trait($request,'logo',self::FOLDER_PATH,self::FOLDER_NAME,$old_logo);

                $updateImage= updateImageResizeWithoutBg($request->logo, self::FOLDER_PATH, self::FOLDER_NAME, $old_logo,true,true);


                $brand->update([
                    'logo'=>$updateImage
                ]);
            }

            $brand->update([
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'is_featured'=>$request->is_featured,
                'status'=>$request->status,
            ]);

            DB::commit();
            toastr()->success("The Brand $request->name Is Updated Successfully !");
            return redirect()->route('admin.brand.index');

        } catch (ValidationException $e) {

            DB::rollback();
            toastr($e->getMessage(),'error','Error');
            return redirect()->back();
            
        }catch(\Exception $ex){

            DB::rollback();
            toastr()->error( $ex->getMessage());
            return redirect()->back();;
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $brand = Brand::find($id);

            if(!$brand){
                return response(['status'=>'error','message'=>'Brand is not found!']);
            }


            $brand_name =$brand->name;


            # Check if the brand have product(s): [without using relation]
            // if(Product::where('brand_id',$brand->id)->count() > 0){

            //     return response(['status'=>'error','message'=>"$brand_name Can't Deleted Because they have products communicated with it !"]);
            // }
            $products = Product::where('brand_id',$brand->id)->get() ;
            if(isset($products) && count($products) > 0){
                
                foreach($products as $product){
                    $product->brand_id = null;
                    $product->save();
                }
            }


            # Check if the brand have product(s): [using relation]
            // if(isset($brand->products)  && count($brand->products) > 0){

            //     return response(['status'=>'error','message'=>"$brand_name Can't Deleted Because they have products communicated with it !"]);
            // }

            $this->deleteImage_Trait($brand->logo);
            $brand->delete();

            // we are using ajax :
            return response(['status'=>'success','message'=>"$brand_name Brand Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>$e->getMessage()]);
            // return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }



    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:brands,id',
            'status' => 'required|in:true,false',
        ]);
        
        $brand =Brand::find($request->id);

        if(!$brand){
            return response(['status'=>'error','message'=>'Brand is not found!']);
        }

        $brand_name = $brand->name;

        # Check if the brand have product(s): [without using relation]
        // if(Product::where('brand_id',$brand->id)->count() > 0){

        //     return response(['status'=>'error','message'=>"$brand_name contain a product(s) ,if you want to deactive brand you have to desactive the product(s) first "]);
        // }
        # Check if the brand have product(s): [using relation]
        // if(isset($brand->products)  && count($brand->products) > 0){

        //     return response(['status'=>'error','message'=>"$brand_name contain a product(s) ,if you want to deactive brand you have to desactive the product(s) first "]);
        // }





        $brand->status = $request->status == 'true' ? 1 : 0;

        $brand->save();

        $status =($brand->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Brand has been $status"]);


    }
}
