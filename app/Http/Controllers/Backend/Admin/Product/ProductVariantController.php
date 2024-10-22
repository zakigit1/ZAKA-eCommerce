<?php

namespace App\Http\Controllers\Backend\Admin\Product;

use App\DataTables\ProductsVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,ProductsVariantDataTable $dataTable)
    {
        
        $product = Product::find($request->id); //* key is -- id --

        if(!$product){
            toastr()->error( 'Product is not found!');
            return to_route('admin.product-image-gallery.index',['id'=>$request->product_id]);
        }
        return $dataTable->render('admin.product.variant.index',compact('product'));
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // dd($request->all());
        return view('admin.product.variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:200',
            'product_id'=> 'required|numeric|exists:products,id',
            'status'=> 'required',
        ]);

        // dd($request->all());
        try{

            ProductVariant::create([
                'name'=> $request->name,
                'product_id'=> $request->product_id,
                'status'=> $request->status,
            ]);
    
            toastr('Variant Has Been Created Successfully ','success');
            return redirect()->route('admin.product-variant.index',['id'=>$request->product_id]);
    
        }catch(\Exception $e){
            // toastr()->error($e->getMessage());
            toastr('variant Has Not Been Updated Successfully','error');
            return redirect()->route('admin.product-variant.index',['id'=>$request->product_id]);
        }

    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product_variant = ProductVariant::find($id);

        if(!$product_variant){
            $product_id =$product_variant->product->id;
            toastr()->error( 'Product is not found!');
            return to_route('admin.product.index',['id'=> $product_id]);
        }

        return view('admin.product.variant.edit',['variant'=>$product_variant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {        
        $request->validate([
        'name'=> 'required|max:200',
        'status'=> 'required',
        ]);

        // dd($request->all());

        try{

            $product_variant = ProductVariant::find($id);

            // $product_id =$product_variant->product->id;//from the relation 

            if(!$product_variant){
                toastr()->error( 'Product is not found!');
                return to_route('admin.product.index',['id'=> $product_variant->product_id]);
            }

            $product_variant->update($request->except(['_token','submit']));

            // $product_variant->update([
            //     'name'=> $request->name,
            //     'status'=> $request->status,
            // ]);
    
            toastr('variant Has Been Updated Successfully','success');
            return redirect()->route('admin.product-variant.index',['id'=>$product_variant->product_id]);
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

            $product_variant = ProductVariant::find($id);

            if(!$product_variant){
                // $product_id =$product_variant->product->id;

                return response(['status'=>'error','message'=>'Product Variant is not exists!']);
            }


            ####### M1:
            $item =ProductVariantItem::where('product_variant_id',$product_variant->id)->count();

            if($item>0){
                return response(['status'=>'error','message'=>" $product_variant->name contain a variant items , for delete this variant you have to delete the variant item first "]);

            }

            ####### M2:relation
            // if(isset($product_variant->items)  && count($product_variant->items)>0){

            //     return response(['status'=>'error','message'=>" $product_variant->name contain a variant items , for delete this variant you have to delete the variant item first "]);
            // }




            $product_variant->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>" Variant Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
    public function change_status(Request $request)
    {
        $product_variant =ProductVariant::find($request->id);

        if(!$product_variant){
            return response(['status'=>'error','message'=>'Product variant is not found!']);
        }


        
        $product_variant->status = $request->status == 'true' ? 1 : 0;
         
        $product_variant->save();

        $status =($product_variant->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Product variant has been $status"]);

       
    }
}
