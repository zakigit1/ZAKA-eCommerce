<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request){

        // dd($request->all());


        $product = Product::findOrFail($request->product_id);

        //check the quantity : 
        if($product->qty == 0){
            return response()->json(['status' => 'warning','message' => "Sorry ! $product->name Product Is Out Of Stock !"]);
        }elseif($product->qty < $request->qty){
            return response()->json(['status'=> 'warning','message' =>" Sorry ! This $product->name Product quantity is not available in the stock !"]);
        }


        $variants=[];
        $variantTotalAmount = 0;
        if($request->has('variant_items')){
            foreach($request->variant_items as $item_id){
                $variantItem = ProductVariantItem::find($item_id);
                $variants[$variantItem->variant->name]['name'] = $variantItem ->name ;
                $variants[$variantItem->variant->name]['price'] = $variantItem ->price ;
                $variantTotalAmount += $variantItem -> price;
            }

        }
        // dd($variants);

        /** Check Discount : */
        
        $productPrice = 0 ;

        if(check_discount($product)){
            $productPrice = $product->offer_price ;
            
        }else{
            $productPrice = $product->price  ;
        }

        $cartData=[];

        $cartData['id'] = $product -> id ;  
        $cartData['name'] = $product -> name ;  
        $cartData['qty'] = $request -> qty ;  
        $cartData['price'] =  $productPrice  ;  
        $cartData['weight'] = 10 ;  
        $cartData['options']['variants'] = $variants  ;  
        $cartData['options']['variants_total_amount'] = $variantTotalAmount ;  
        $cartData['options']['image'] = $product -> thumb_image ;  // if you will storage in to db change the path image to just image name
        $cartData['options']['slug'] = $product -> slug ;  


        // dd($cartData);
        
        $cart = Cart::add($cartData);
        // dd($cart->rowId);
 
        return response()->json([
            'status' => 'success',
            'message' => 'Added To Cart Successfully !'
        ],200);
    }

    /** Show Cart Page : */
    public function cartDetails(){
        
        // Cart::destroy();
       
        $cartProducts = Cart::content();

        if(count($cartProducts) == 0 ){
            toastr('Please add some products in your cart for view the cart page !','warning','Cart Is Empty !');
            return redirect()->route('home');
        }

        // dd($cartProducts);
        // dd($cartProducts['400e29e1df375d66dcb86a793720c4d0']->rowId);

        return view('Frontend.store.pages.cart-details',compact('cartProducts'));
    }

    /** Quantity Increment : */
    public function quantityUpdate(Request $request){

        // dd($request->all());
        $product_id = Cart::get($request->rowId)->id;

        $product = Product::findOrFail($product_id);

        //check the quantity : 
        if($product->qty == 0){
            return response()->json(['status' => 'warning','message' => "Sorry ! $product->name Product Is Out Of Stock !"]);
        }elseif($product->qty < $request->quantity){
            return response()->json(['status'=> 'warning','message' =>" Sorry ! This $product->name Product quantity is not available in the stock !"]);
        }


        Cart::update($request->rowId,$request->quantity);
        $product_total_amount = $this->getProductTotal($request->rowId);


        return response()->json([
            'status' => 'success',
            'message' => 'Product Quantity Updated Successfully !',
            'product_total_amount' => $product_total_amount 

        ],200);
    }

    /** Calculate the total price of product :  (this function we are use it in the quantityUpdate function */
    public function getProductTotal(string $rowId){
        
        $product = Cart::get($rowId);

        $total = ($product->price + $product->options->variants_total_amount) * $product->qty;

        return $total ;
    }


    // Calculate the subtotal in the sidebar cart :
    public function cartTotalSidebar(){
        $total = 0; 
        
        foreach(Cart::content() as $product){

            $total += $this->getProductTotal($product->rowId);
        }
        return $total;
    }

    /** Remove Product From Cart ( Cart Details page) : */
    public function removeProduct(string $rowId){
        
        Cart::remove($rowId);
        // return redirect()->back();

        //if you use ajax use this redirect : 
        return response(['status'=>'success','message'=>"Product Has Been Removed Successfully From The Cart !",'rowId'=>$rowId]);
    }

    /** Clear all Product Frome The Cart  ( Cart Details page) : */
    public function clearCart(){
        
        Cart::destroy();
        return response(['status'=>'success','message'=>"Cart Is Empty Now !"]);
    }

    /** Counter Cart :   */
    public function getCartCount(){

        return Cart::content()->count();
    }

    /** Get Products form the Cart : */
    public function getCartProducts(){

        return Cart::content();
    }

    /** Remove Product From Cart Sidebar : */
    public function removeSidebarProduct(Request $request){
        // dd($request->all());
        
        Cart::remove($request->rowId);
        return  response(['status'=>'success','message'=>"Product Has Been Removed Successfully From The Cart Sidebar !"]);
    }


}
