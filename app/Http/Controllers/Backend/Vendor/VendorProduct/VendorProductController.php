<?php

namespace App\Http\Controllers\Backend\Vendor\VendorProduct;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Vendor;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator ;

class VendorProductController extends Controller
{

    use imageUploadTrait;

    const FOLDER_PATH = '/Uploads/images/products/';
    const FOLDER_NAME = 'thumb-images';
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductDataTable $DataTable)
    {
        return $DataTable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data=[];
        $data['categories']=Category::all(['id','name']);
        $data['brands']=Brand::all(['id','name']);
        $data['vendors']=Vendor::all(['id']);
        return view('vendor.product.create',$data);
    }


    // AJAX 
    public function get_subcategories(Request $request){


        $subcategories = Subcategory::where('category_id',$request->category_id)->active()->get(['id','name']);
        // $subcategories = Subcategory::where('category_id',$request->id)->active()->get();

        return $subcategories;

    }
    public function get_childcategories(Request $request){

        $childcategories = Childcategory::where('sub_category_id',$request->sub_category_id)->active()->get(['id','name']);
        

        return $childcategories;

    }



    public function store(Request $request)
    { 
        $rules=[
            'thumb_image' => 'required|image|max:3000',
            'name' => 'required|max:200',
            'category' => 'required',
            'brand' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'short_description' => 'required|max:600',
            'long_description' => 'required',
            'seo_title'=>'nullable|max:200',
            'seo_description'=>'nullable|max:250',
            'video_link'=>'nullable|url',
            'status' => 'required',  
        ];
        $validation= Validator::make($request->all(),$rules);

        if($validation->fails()){

            return redirect()->back()->withErrors($validation)->withInput();
        }


        // dd($request->all());

        try{

            $imageName=$this->uploadImage_Trait($request,'thumb_image',self::FOLDER_PATH,VendorProductController::FOLDER_NAME);

            $product=Product::create([
                'thumb_image'=>$imageName,
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'vendor_id'=>Auth::user()->vendor->id,//we are using a relation 
                'category_id'=>$request->category,
                'sub_category_id'=>$request->subcategory,
                'child_category_id'=>$request->childcategory,
                'brand_id'=>$request->brand,
                'price'=>$request->price,
                'qty'=>$request->qty,
                'short_description'=>$request->short_description,
                'long_description'=>$request->long_description,
                'video_link'=>$request->video_link,
                'sku'=>$request->sku,
                'offer_price'=>$request->offer_price,
                'offer_start_date'=>$request->offer_start_date,
                'offer_end_date'=>$request->offer_end_date,
                'seo_title'=>$request->seo_title,
                'seo_description'=>$request->seo_description,
                'product_type'=>$request->product_type,
                'is_approved'=> 0,//because this product is of  vendor he need the admin to approve it
                'status'=>$request->status,
            ]);

            // dd($product); 
            toastr(' Product has been created successfully','success');

            return to_route('vendor.product.index');
        }catch(\Exception $ex){

            toastr($ex->getMessage(),'error');
            // toastr('Product has not been created successfully','error');
            return to_route('vendor.product.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function edit(string $id)
    {

        $data=[];
        
        $data['product'] = Product::find($id);

        if(!$data['product']){
            toastr()->error( 'Product is not found!');
            return to_route('vendor.product.index');
        }

        /** check if it's the owner of the product  : */
        if($data['product']->vendor_id != Auth::user()->vendor->id){

            // return to_route('404');

            //*-------------------------------------------
            //? this i can use it for me to know the error but when you host your website you should to redirect to the 404 page 
            toastr()->error( 'You are not authorized to edit this product!');
            return to_route('vendor.product.index');
        }


        $data['categories'] = Category::get(['id','name']);

        $data['subcategories'] = Subcategory::where('category_id',$data['product']->category_id)->get(['id','name']);
        $data['childcategories'] = Childcategory::where('sub_category_id',$data['product']->sub_category_id)->get(['id','name']);

        $data['brands'] = Brand::where('id',$data['product']->brand_id)->get(['id','name']);
        
        // dd($data['product'] );
        return view('vendor.product.edit',$data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'thumb_image' => 'nullable|image|max:8264',
            'name' =>'required|max:200',
            'category' =>'required',
            'brand' =>'required',
            'price' =>'required|numeric',
            'qty' =>'required|numeric',
            'short_description' =>'required|max:600',
            'long_description' =>'required',
            'seo_title'=>'nullable|max:200',
            'seo_description'=>'nullable|max:250',
            'video_link'=>'nullable|url',
            'status' => 'required',
        ]);

        // dd($request->all());

        try{

            DB::beginTransaction();

            

            $product=Product::find($id);
            
            if(!$product){
                toastr()->error( 'Product is not found!');
                return to_route('vendor.product.index');
            }

            /** check if it's the owner of the product  : */
            if($product->vendor_id != Auth::user()->vendor->id){

                // return to_route('404');

            //*-------------------------------------------
            //? this i can use it for me to know the error but when you host your website you should to redirect to the 404 page 
                toastr()->error( 'You are not authorized to edit this product!');
                return to_route('vendor.product.index');
            }
  
            if($request->hasFile('thumb_image')){
                
                $old_image = $product->thumb_image;
                $imageName=$this->updateImage_Trait($request,'thumb_image',self::FOLDER_PATH,self::FOLDER_NAME,$old_image);

                
                $product->update([
                    'thumb_image'=>$imageName,
                ]);
            }

            $update_product = $product->update([
                
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'category_id'=>$request->category,
                'sub_category_id'=>$request->subcategory,
                'child_category_id'=>$request->childcategory,
                'brand_id'=>$request->brand,
                'price'=>$request->price,
                'qty'=>$request->qty,
                'short_description'=>$request->short_description,
                'long_description'=>$request->long_description,
                'video_link'=>$request->video_link,
                'sku'=>$request->sku,
                'offer_price'=>$request->offer_price,
                'offer_start_date'=>$request->offer_start_date,
                'offer_end_date'=>$request->offer_end_date,
                'seo_title'=>$request->seo_title,
                'seo_description'=>$request->seo_description,
                'product_type'=>$request->product_type,
                'status'=>$request->status,
            ]);

            DB::commit();
            toastr('Product has been created successfully','success');

            return to_route('vendor.product.index');
        }catch(\Exception $ex){

            DB::rollback();
            toastr($ex->getMessage(),'error');
            // toastr('Product has not been created successfully','error');
            return to_route('vendor.product.index');
        }
    }

    public function destroy(string $id)
    {
        try{ 
            $product = Product::find($id);

            if(!$product){
                toastr()->error( 'Product is not found!');
                return to_route('vendor.product.index');
            }
            
            /** check if it's the owner of the product  : */
            if($product->vendor_id != Auth::user()->vendor->id){

                // return to_route('404');

            //*-------------------------------------------
            //? this i can use it for me to know the error but when you host your website you should to redirect to the 404 page 
                toastr()->error( 'You are not authorized to delete this product!');
                return to_route('vendor.product.index');
            }

            $product_name =$product->name;

            //********************   Delete Product the thumb image    ******************** */
            
            $this->deleteImage_Trait($product->thumb_image);
            

            //********************   Delete Product Gallery    ******************** */

            #M1: 
            // $product_gallery =ProductImageGallery::where('product_id',$product->id)->get();
            
            // foreach($product_gallery as $product_image){
            //     $this->deleteImage_Trait($product_image->image);
            //     $product_image->delete();
            // }


            #M2: 
            if(isset($product->gallery)  && count($product->gallery)>0){
                foreach($product->gallery as $product_image){
                    $this->deleteImage_Trait($product_image->image);
                    $product_image->delete();
                }
            }
            //********************   Delete variants & items     ******************** */
            
            ##M1: 
            // $variants = ProductVariant::where('product_id',$product->id)->get();
        
            // foreach($variants as $variant){
            //     $variant->items()->delete();//if you use after calling a relation a method you need to add in the name of relation bracket like tahe RelationName() 
            //     $variant->delete();
            // }

            
            ##M2: 
            if (isset($product->variants) && count($product->variants) > 0) {
                foreach ($product->variants as $variant) {
                    if (isset($variant->items) && count($variant->items) > 0) {
                        foreach ($variant->items as $item) {
                            $item->delete();
                        }
                        $variant->delete();
                    } else {
                        $variant->delete();
                    }
                }
            }

            
            //********************   Delete Product  *****************//
               
            $product->delete();


            // we are using ajax : 
            return response(['status'=>'success','message'=>"$product_name Brand Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>$e->getMessage() ]);
            // return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function change_status(Request $request)
    {
        $product =Product::find($request->id);

        if(!$product){
            toastr()->error( 'Product is not found!');
            return to_route('vendor.product.index');
        }

        $product_name =$product->name;


        ### to check if category have subcategories , we can't desactive the status 
        // $subcategories =Subcategory::where('category_id',$category->id)->count();

        // if($subcategories>0 && $request->status != 'true'){
        //     return response(['status'=>'error','message'=>"$category_name contain a Sub categories ,if you want to deactive the  Main category you have to desactive the Sub categories first "]);
        // }

        
        $product->status = $request->status == 'true' ? 1 : 0;
         
        $product->save();

        $status =($product->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Product has been $status"]);

       
    }




}
