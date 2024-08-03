<?php

namespace App\Http\Controllers\Backend\Admin\Product;

use App\DataTables\SellerProductDataTable;
use App\DataTables\SellerPendingProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    public function index(SellerProductDataTable $dataTable){
        return $dataTable->render('admin.product.seller-product.index');
    }


    public function pending_products(SellerPendingProductDataTable $dataTable){
        return $dataTable->render('admin.product.seller-product.pending.index');
    }
    public function change_approve_status(Request $request){
       $product = Product::find($request->id);

        if(!$product){
            toastr()->error( 'Product is not found!');
            return redirect()->back();
        }
        
       $product->is_approved = $request->value;
       $product->save();

       $approve_status =($product->is_approved == 1) ? 'approve' : 'pending';
       return response(['status'=>'success','message'=>"The Product has been $approve_status"]);
    }
    
}
