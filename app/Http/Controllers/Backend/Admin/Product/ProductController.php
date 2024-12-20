<?php

namespace App\Http\Controllers\Backend\Admin\Product;

use App\DataTables\AllProductsDataTable;
use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Vendor;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use imageUploadTrait;

    private const FOLDER_PATH = '/Uploads/images/products/';
    private const FOLDER_NAME = 'thumb-images';


    public function getAllProducts(AllProductsDataTable $dataTable){
        return $dataTable->render('admin.product.all-product.index');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(ProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');   
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
        return view('admin.product.create',$data);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
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
        ]);

        // dd($request->all());

        try{

            $imageName=$this->uploadImage_Trait($request,'thumb_image',self::FOLDER_PATH,ProductController::FOLDER_NAME);

            $product= Product::create([
                'thumb_image'=>$imageName,
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'vendor_id'=>Auth::user()->vendor->id,
                'category_id'=>$request->category,
                'sub_category_id'=>$request->subcategory,
                'child_category_id'=>$request->childcategory,
                'brand_id'=>$request->brand,
                'price'=>$request->price,
                'offer_price'=>$request->offer_price,
                'offer_start_date'=>$request->offer_start_date,
                'offer_end_date'=>$request->offer_end_date,
                'qty'=>$request->qty,
                'short_description'=>$request->short_description,
                'long_description'=>$request->long_description,
                'video_link'=>$request->video_link,
                'sku'=>$request->sku,
                'seo_title'=>$request->seo_title,
                'seo_description'=>$request->seo_description,
                'product_type'=>$request->product_type,
                'is_approved'=> 1,//because this product is of admin vendor he dont need to approve it
                'status'=>$request->status,
            ]);

            // dd($product);
            toastr('Product has been created successfully','success');

            return to_route('admin.product.index');
        }catch(\Exception $ex){

            // toastr($ex->getMessage(),'error');
            toastr('Product has not been created successfully','error');
            return to_route('admin.product.index');
        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data=[];
        
        $data['product'] = Product::find($id);

        if(!$data['product']){
            toastr()->error( 'Product is not found!');
            return to_route('admin.product.index');
        }

        /** check if it's the owner of the product  : */
        // if($data['product']->vendor_id != Auth::user()->vendor->id){

        //     //abort(404);
        //     toastr()->error( 'You are not authorized to edit this product!');
        //     return to_route('vendor.product.index');
        // }

        $data['categories'] = Category::get(['id','name']);

        $data['subcategories'] = Subcategory::where('category_id',$data['product']->category_id)->get(['id','name']);
        $data['childcategories'] = Childcategory::where('sub_category_id',$data['product']->sub_category_id)->get(['id','name']);

        $data['brands'] = Brand::where('id',$data['product']->brand_id)->get(['id','name']);
       


        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
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
                return to_route('admin.product.index');
            }

            /** check if it's the owner of the product  : */
            // if($product->vendor_id != Auth::user()->vendor->id){

                //abort(404);
            //     toastr()->error( 'You are not authorized to edit this product!');
            //     return to_route('vendor.product.index');
            // }
  
            if($request->hasFile('thumb_image')){
                
                $old_image = $product->thumb_image;
                $imageName=$this->updateImage_Trait($request,'thumb_image',self::FOLDER_PATH,ProductController::FOLDER_NAME,$old_image);

                
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
            toastr('Product has been updated successfully','success');

            return to_route('admin.product.index');
            // return redirect()->back();
        }catch(\Exception $ex){

            DB::rollback();
            // toastr($ex->getMessage(),'error');
            toastr('Product has not been updated successfully','error');
            return to_route('admin.product.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 
            $product = Product::find($id);

            if(!$product){
                return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
            }

            //you can use relation 
            if(OrderProduct::where('product_id',$product->id)->count() > 0){
                return response(['status'=>'error','message'=>"This Product Have Order(s) You Can'\t Delete it!"]);
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
            return response(['status'=>'error','message'=>'Product is not found!']);
        }


        
        $product->status = $request->status == 'true' ? 1 : 0;
         
        $product->save();

        $status =($product->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Product has been $status"]);

       
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
}
