<?php

namespace App\Http\Controllers\Backend\Admin\Product;

use App\DataTables\ProductsImagesGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;

class ProductImageGalleryController extends Controller
{
    use imageUploadTrait;


    const FOLDER_PATH = '/Uploads/images/products/';
    const FOLDER_NAME = 'gallery';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request , ProductsImagesGalleryDataTable $dataTable)
    {
        
        $product = Product::find($request->id);

        if(!$product){
            toastr()->error( 'Product is not found!');
            return to_route('admin.product-image-gallery.index',['id'=>$request->product_id]);
        }

        return $dataTable->render('admin.product.image-gallery.index',compact('product'));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image.*'=>['required','image','max:80640'],
            'product_id'=>['required','numeric','exists:products,id']
        ]);
         
        // dd($request->all());
        try{
            $imagesNames=$this->upload_Multi_Image_Trait($request,'image',self::FOLDER_PATH,self::FOLDER_NAME);
        

            //! First Method
            // foreach($imagesNames as $imageName){
            //     ProductImageGallery::create([
            //         'image'=>$imageName,
            //         'product_id'=>$request->product_id
            //     ]);
            // }
    
            //! Second Method
            // foreach($imagesNames as $imageName){
  
            //    $store_image_product =new ProductImageGallery();
    
            //     $store_image_product->image=$imageName;
            //     $store_image_product->product_id = $request->product_id;
    
            //     $store_image_product->save();
            // }
    
            // return true;
            //? Third Method (more optimaze it)
            $data = [];
    
            foreach ($imagesNames as $imageName) {
                $data[] = [
                    'image' => $imageName,
                    'product_id' => $request->product_id
                ];
            }
            //  return print_r($data);
            $storeImages = ProductImageGallery::insert($data);
    
    
            toastr('Product Images has been added successfully!','success');
            return to_route('admin.product-image-gallery.index',['id'=>$request->product_id]);
            // return redirect()->back();

        }catch(\Exception $e){

            toastr($e->getMessage(),'error');
            // toastr('Product Images has not been added successfully!','error');
            // return to_route('admin.product-image-gallery.index',['id'=>$request->product_id]);
            return redirect()->back();
        }


    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $product_gallery = ProductImageGallery::find($id);

            if(!$product_gallery){
                return response(['status'=>'error','message'=>'Product Gallery is not found!']);
            }


            $this->deleteImage_Trait($product_gallery->image);
            $product_gallery->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>" Image Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function destroyAllImages(string $id)
    {
        try {
            
            $product = Product::find($id);
            if(!$product){
                return response(['status'=>'error','message'=>'Product is not found!']);
            }
            if(isset($product->gallery)  && count($product->gallery)>0){
                foreach($product->gallery as $product_image){
                    $this->deleteImage_Trait($product_image->image);
                    $product_image->delete();
                }
            }

            // Return success response
            return response(['status' => 'success', 'message' => "All Images Have Been Deleted Successfully!"]);
        } catch (\Exception $e) {
            // Return error response
            return response(['status' => 'error', 'message' => 'An error occurred. Please try again later.']);
        }
    }
}
