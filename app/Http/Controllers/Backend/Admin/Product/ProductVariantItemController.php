<?php

namespace App\Http\Controllers\Backend\Admin\Product;

use App\DataTables\ProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductVariantItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(ProductVariantItemDataTable $DataTable,string $productId,string $variantId)
    {
        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);
        return $DataTable->render('Admin.product.variant-item.index',compact('product','variant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $productId,int $variantId)
    {
        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);
        return view('admin.product.variant-item.create',compact('product','variant'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            return redirect()->route('admin.product-variant-item.index',['productId'=>$request->product_id,'variantId'=>$request->variant_id]);
    
        }catch(\Exception $e){
            // toastr()->error($e->getMessage());
            toastr('variant Has Not Been Created Successfully','error');
            return redirect()->route('admin.product-variant-item.index',['productId'=>$request->product_id,'variantId'=>$request->variant_id]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product_variant_item = ProductVariantItem::find($id);
        
        $variant_id=$product_variant_item->product_variant_id;

        ##M1:
        // $productId = ProductVariant::select('product_id')->find($product_variant_item->product_variant_id);
        // $product_id =$productId->product_id;
        
        ##M2:
        $product_id =$product_variant_item->variant->product_id;

        if(!$product_variant_item){
       
            toastr()->error( 'item is not found!');
            return to_route('admin.product-variant-item.index',[$product_id,$variant_id]);
        }

    

        return view('admin.product.variant-item.edit',['item'=>$product_variant_item,'product_id'=>$product_id,'variant_id'=>$variant_id]);
    }

    /**
     * Update the specified resource in storage.
     */
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
    
                $variant_id= $item->product_variant_id;

                ##M1:
                // $productId = ProductVariant::select('product_id')->find($product_variant_item->product_variant_id);
                // $product_id =$productId->product_id;
                
                ##M2:
                $product_id =$item->variant->product_id;
    
                if(!$item){
       
                    toastr()->error( 'item is not found!');
                    return to_route('admin.product-variant-item.index',[$product_id,$variant_id]);
                }
    
                $item->update($request->except(['_token','submit']));
    

        
                toastr('Variant Item Has Been Updated Successfully ','success');
                return redirect()->route('admin.product-variant-item.index',[$product_id,$variant_id]);
        
            }catch(\Exception $e){
                // toastr()->error($e->getMessage());
                toastr('variant Has Not Been Updated Successfully','error');
                return redirect()->back();
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $item = ProductVariantItem::find($id);
            $variant_id= $item->product_variant_id;

            ##M1:
            // $productId = ProductVariant::select('product_id')->find($product_variant_item->product_variant_id);
            // $product_id =$productId->product_id;
            
            ##M2:
            $product_id =$item->variant->product_id;
            if(!$item){
                
                return response(['status'=>'error','message'=>'Product variant item is not found!']);
            }

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
    
        if(!$item){
           
            return response(['status'=>'error','message'=>'Product variant item is not found!']);
        }

        $item->status = $request->status == 'true' ? 1 : 0;
         
        $item->save();

        $status =($item->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Product variant has been $status"]);

       
    }
}
