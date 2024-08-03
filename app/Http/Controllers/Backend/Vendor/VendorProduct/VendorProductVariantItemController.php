<?php

namespace App\Http\Controllers\Backend\Vendor\VendorProduct;

use App\DataTables\VendorProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class VendorProductVariantItemController extends Controller
{
    public function index(VendorProductVariantItemDataTable $DataTable,string $productId,string $variantId)
    {
        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);

        if(!$product){

            toastr()->error( 'Product  is not found!');
            return redirect()->back();
        }
        if(!$variant){
            toastr()->error( 'Product Variant is not found!');
            return redirect()->back();
        }

        /** 
            ** check if it's the owner of the product  : */ 
        
        if($product->vendor_id != auth()->user()->vendor->id || $variant->product->vendor_id !=auth()->user()->vendor->id){
            
                // return to_route('404');

            //*-------------------------------------------

            //? this i can use it for me to know the error but when you host your website you should to redirect to the 404 page 
            toastr()->error( 'You are not authorized to see this product variant items !');
            return redirect()->route('vendor.product-variant.index',['id'=>$productId]);
            return redirect()->back();
            
        }

        return $DataTable->render('vendor.product.variant-item.index',compact('product','variant'));
    }

    public function create(int $productId,int $variantId)
    {
        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);

        if(!$product){

            toastr()->error( 'Product  is not found!');
            return redirect()->back();
        }
        if(!$variant){
            toastr()->error( 'Product Variant is not found!');
            return redirect()->back();
        }
        return view('vendor.product.variant-item.create',compact('product','variant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:200',
            'variant_id'=> 'required|numeric|exists:product_variants,id',
            'price'=> 'required|numeric',
            'is_default'=> 'required',
            'status'=> 'required',
        ]);

        // dd($request->all());
        try{

            ProductVariantItem::create([
                'name'=> $request->name,
                'product_variant_id'=> $request->variant_id,
                'price'=> $request->price,
                'is_default'=> $request->is_default,
                'status'=> $request->status,
            ]);
    
            // DB::table('product_variant_items')->insert([
            //     'name'=> $request->name,
            //     'product_variant_id'=> $request->variant_id,
            //     'price'=> $request->price,
            //     'is_default'=> $request->is_default,
            //     'status'=> $request->status,
            // ]);

            toastr('Variant Item Has Been Created Successfully ','success');
            //? same method:
            // return to_route('vendor.product-variant-item.index',[$product_id,$variant_id]);
            return redirect()->route('vendor.product-variant-item.index',['productId'=>$request->product_id,'variantId'=>$request->variant_id]);
            
        }catch(\Exception $e){
            // toastr()->error($e->getMessage());
            toastr('variant Has Not Been Created Successfully','error');
            return redirect()->route('vendor.product-variant-item.index',['productId'=>$request->product_id,'variantId'=>$request->variant_id]);
        }
    }

    public function edit(string $id)
    {
        $product_variant_item = ProductVariantItem::find($id);


        if(!$product_variant_item){
            toastr()->error( 'this item is not found!');
            return redirect()->back(); 
        }
        
        $variant_id=$product_variant_item->product_variant_id;

        $variant = ProductVariant::find($variant_id);


        if(!$product_variant_item){

            toastr()->error( 'this item is not found!');
            return redirect()->back();
        }
        if(!$variant){
            toastr()->error( 'Product Variant is not found!');
            return redirect()->back();
        }

        ##M1:
        // $productId = ProductVariant::select('product_id')->find($product_variant_item->product_variant_id);
        // $product_id =$productId->product_id;
        
        ##M2:
        $product_id =$product_variant_item->variant->product_id;

        
        /** 
           ** check if it's the owner of the product and also this variant   : */
        if($product_variant_item->variant->product->vendor_id != auth()->user()->vendor->id || $variant->product->vendor_id !=auth()->user()->vendor->id){
                // return to_route('404');

            //*-------------------------------------------

            //? this i can use it for me to know the error but when you host your website you should to redirect to the 404 page 
                toastr()->error( 'You are not authorized to edit this product variant item !');
                
                return redirect()->back();
        }

    
        return view('vendor.product.variant-item.edit',['item'=>$product_variant_item,'product_id'=>$product_id,'variant_id'=>$variant_id]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=> 'required|max:200',
            'price'=> 'required|numeric',
            'is_default'=> 'required',
            'status'=> 'required',
        ]);
    
            // dd($request->all());
    
            try{
    
                $item = ProductVariantItem::find($id);

    
                if(!$item){
       
                    toastr()->error( 'item is not found!');
                    return redirect()->back();
                }
    


                $variant_id= $item->product_variant_id;
                $variant = ProductVariant::find($variant_id);//? i add this line just for check variant 

                $product_id =$item->variant->product_id;


        /** 
           ** check if it's the owner of the product and also this variant   : */
            if($item->variant->product->vendor_id != auth()->user()->vendor->id || $variant->product->vendor_id !=auth()->user()->vendor->id){
                    // return to_route('404');

                //*-------------------------------------------

                //? this i can use it for me to know the error but when you host your website you should to redirect to the 404 page 
                    toastr()->error( 'You are not authorized to update this product variant item !');
                    return to_route('vendor.product-variant-item.index',[$product_id,$variant_id]);
                    // return redirect()->back();
            }
    
                
          

                $item->update($request->except(['_token','submit']));
    

        
                toastr('Variant Item Has Been Updated Successfully ','success');
                return redirect()->route('vendor.product-variant-item.index',[$product_id,$variant_id]);
        
            }catch(\Exception $e){
                // toastr()->error($e->getMessage());
                toastr('variant Has Not Been Updated Successfully','error');
                return redirect()->route('vendor.product-variant-item.index',[$product_id,$variant_id]);
            }
    }

    public function destroy(string $id)
    {
        try{ 

            $item = ProductVariantItem::find($id);
            $variant_id= $item->product_variant_id;
            $variant = ProductVariant::find($variant_id);
            $product_id =$item->variant->product_id;

            if(!$item){
                
                toastr()->error( 'Product Item is not exsist!');
                return to_route('vendor.product-variant-item.index',[$product_id, $variant_id]);
                // return redirect()->back();
            }
            
        /** 
           ** check if it's the owner of the product and also this variant   : */
            if($item->variant->product->vendor_id != auth()->user()->vendor->id || $variant->product->vendor_id !=auth()->user()->vendor->id){
                    // return to_route('404');

                //*-------------------------------------------

                //? this i can use it for me to know the error but when you host your website you should to redirect to the 404 page 
                    toastr()->error( 'You are not authorized to update this product variant item !');
                    return to_route('vendor.product-variant-item.index',[$product_id,$variant_id]);
                    // return redirect()->back();
            }

            ##M1:
            // $productId = ProductVariant::select('product_id')->find($product_variant_item->product_variant_id);
            // $product_id =$productId->product_id;
            
            
            $item->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>" Item Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function change_status(Request $request)
    {
        $item =ProductVariantItem::find($request->id);
        $variant_id= $item->product_variant_id;
        $variant = ProductVariant::find($variant_id);
        ##M1:
        // $productId = ProductVariant::select('product_id')->find($product_variant_item->product_variant_id);
        // $product_id =$productId->product_id;
        
        ##M2:
        $product_id =$item->variant->product_id;


        if(!$item){
           
            toastr()->error( 'Item is not found!');
            return to_route('vendor.product-variant-item.index',[$product_id, $variant_id]);
            // return redirect()->back();
        }

        
        /** 
           ** check if it's the owner of the product and also this variant   : */
          if($item->variant->product->vendor_id != auth()->user()->vendor->id || $variant->product->vendor_id !=auth()->user()->vendor->id){
            // return to_route('404');

        //*-------------------------------------------

        //? this i can use it for me to know the error but when you host your website you should to redirect to the 404 page 
            toastr()->error( 'You are not authorized to edit this product variant item !');
            return redirect()->back();
    }
        
        $item->status = $request->status == 'true' ? 1 : 0;
         
        $item->save();

        $status =($item->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Product variant has been $status"]);

       
    }
}
