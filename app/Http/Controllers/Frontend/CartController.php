<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Coupon;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

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

        // Product Qty Verfied :
        $updateQty = ($product->qty - $request->qty);
        $product->qty = $updateQty ;
        $product->save();
        
       
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

            Session::forget('coupon');
            toastr('Please add some products in your cart for view the cart page !','warning','Cart Is Empty !');
            return redirect()->route('home');
        }

        // dd($cartProducts);
        // dd($cartProducts['400e29e1df375d66dcb86a793720c4d0']->rowId);


        // The banners :
        $cartpageBanner = Advertisement::where('key','cartpage_banner')->first();
        $cartpageBanner = json_decode($cartpageBanner?->value);



        return view('Frontend.store.pages.cart-details',compact('cartProducts','cartpageBanner'));
    }

    /** Quantity Increment : */
    public function quantityUpdate(Request $request){

        try{
            // dd($request->all());
            $productCart = Cart::get($request->rowId);
            // $product_id = Cart::get($request->rowId)->id;
    
            $product = Product::find($productCart->id);
            // $product = Product::findOrFail($product_id);
    
    
            if(!$product){
                return response()->json(['status' => 'warning','message' => "Product Not Found"]);
            }
    

            //check the quantity : 
            if($product->qty == 0 && $request->quantity != $productCart->qty){
                if($request->quantity > $productCart->qty){
                    return response()->json([
                        'status' => 'warning',
                        'qty_max' => $productCart->qty,
                        'message' => "Sorry ! You Can't Add More $product->name Product Because It's Out Of Stock !"]);
                }

                // if($request->quantity > $product->qty && $product->qty ==0){
                //     return response()->json([
                //         'status' => 'warning',
                //         'message' => "Sorry ! the $product->name Product is out of stock !"]);
                // }
            }

            // Product Qty Verfied :
            if($productCart->qty > $request->quantity){
                $qtyNew = $productCart->qty - $request->quantity;
                
                $updateQty = ($product->qty + $qtyNew );
                $product->qty = $updateQty ;
                $product->save();
            }elseif($productCart->qty < $request->quantity){
                $qtyNew = $request->quantity - $productCart->qty ;
                
                $updateQty = ($product->qty - $qtyNew);
                $product->qty = $updateQty ;
                $product->save();
            }else{
                
                $updateQty = ($product->qty - 1);
                $product->qty = $updateQty ;
                $product->save();

            }
    
    
            Cart::update($request->rowId,$request->quantity);
            $product_total_amount = $this->getProductTotal($request->rowId);
    
    
            return response()->json([
                'status' => 'success',
                'message' => 'Product Quantity Updated Successfully !',
                'product_total_amount' => $product_total_amount 
    
            ],200);

        }catch(\Exception $ex){
            return response()->json(['status' => 'warning','message' => $ex->getMessage()]);
        }
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
        

        $cartItem = Cart::get($rowId);
        $product = Product::find($cartItem->id);
        $product->qty = ($product->qty + $cartItem->qty);
        
        // return response(['status'=>'success','message'=>$product->qty]);
        

        $product->save();


        Cart::remove($rowId);
        // return redirect()->back();

        //if you use ajax use this redirect : 
        return response(['status'=>'success','message'=>"Product Has Been Removed Successfully From The Cart !",'rowId'=>$rowId]);
    }

    /** Remove Product From Cart Sidebar : */
    public function removeSidebarProduct(Request $request){

        try{
            $request->validate([
                'rowId' =>'required',
            ]);
            // dd($request->all());
            $cartItem = Cart::get($request->rowId);
            $product = Product::find($cartItem->id);
            $product->qty = ($product->qty + $cartItem->qty);
    
            $product->save();
            
            Cart::remove($request->rowId);
            return  response([
                    'status'=>'success',
                    'message'=>"Product Has Been Removed Successfully From The Cart Sidebar !"
                ]);

        } catch (ValidationException $e) {
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }catch(\Exception $ex){
        return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }

    }


    /** Clear all Product Frome The Cart  ( Cart Details page) : */
    public function clearCart(){
        
        Cart::destroy();
        return response([
                'status'=>'success',
                'message'=>"Cart Is Empty Now !"
            ]);
    }

    /** Counter Cart :   */
    public function getCartCount(){

        return Cart::content()->count();
    }

    /** Get Products form the Cart : */
    public function getCartProducts(){

        return Cart::content();
    }


    /** Check & Apply Coupon  : */

    public function apply_coupon(Request $request)
    {
        try{
            $request->validate([
                'coupon_code' => 'required|exists:coupons,code',
            ],[
                'coupon_code.exists'=> 'This coupon code is not valid !',
            ]);
            // dd($request->all());
    
            if($request->coupon_code === null){
                return response(["status"=> "error","message"=> "Coupon field is required !"]);
            }
    
            $coupon = Coupon::where(['code' => $request->coupon_code ,'status' => 1])->first();
    
            if(!$coupon){
                return response(["status"=> "error","message"=> "Coupon is not exist !"]);
            }elseif($coupon->start_date  > date('Y-m-d') ){ //" < " ->mean befor
                // return response(["status"=> "error","message"=> "Coupon is not exist !"]);
                return response(["status"=> "error","message"=> "Coupon is not start yet !"]);
            }elseif($coupon->end_date < date('Y-m-d')){
                return response(["status"=> "error","message"=> "Coupon is expired !"]);
            }elseif($coupon->total_used >= $coupon->quantity){
                return response(["status"=> "error","message"=> "You can't apply this coupon !"]);
            }
    
    
            if($coupon->discount_type == 'amount'){
                Session::put('coupon',[
                    'coupon_name'=>$coupon->name,
                    'coupon_code'=>$coupon->code,
                    'discount_type'=>$coupon->discount_type,
                    'discount'=>$coupon->discount
                ]);
            }elseif($coupon->discount_type == 'percent'){
    
                $discount = getCartSubtotal() - ((getCartSubtotal() * $coupon->discount) / 100);
    
                Session::put('coupon',[
                    'coupon_name'=> $coupon->name,
                    'coupon_code' => $coupon->code,
                    'discount_type' => $coupon->discount_type,
                    'discount_percentage' => $coupon->discount,
                    'discount'=> $discount
                ]);
    
            }
    
            return response(["status"=> "success","message"=> "Coupon Applied Successfully !"]);

        } catch (ValidationException $e) {
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }catch(\Exception $ex){
            return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }
        


    }

    /** Calculate coupon discount */
    public function couponCalculation()
    {
        try{
            if(Session::has('coupon')){
                $couponSession = Session::get('coupon');// i can use directely couponsession : 
                $coupon = Coupon::where('name',$couponSession['coupon_name'])->first();
    
                $subTotal = getCartSubtotal(); // this function you found it in the general file
    
                if($coupon->discount_type == 'amount'){
    
                    $currency_icon = GeneralSetting::first()->currency_icon;
                    $discountType = $currency_icon.$coupon->discount;
                    $discount = $coupon->discount;
                    $total = max(0,$subTotal - $discount);// the max function for secure if the coupon is great than the price of the product .
    
                    return response()->json(['status'=>'success','discount'=>$discount ,'total'=>$total,'discountType'=>$discountType]);
    
                }elseif($coupon->discount_type == 'percent'){
    
                    $discountType = $coupon->discount.'%'; //this is from DB
                    // $discountType = $couponSession['discount_percentage'].'%'; // this is from the session
    
                    $discount = (($subTotal * $coupon->discount) / 100);
                    $total = round($subTotal - $discount , 2) ; // return two number after the cuma .
    
                    return response()->json(['status'=>'success','discount'=>$discount ,'total'=>$total,'discountType'=>$discountType]);
                }
            }else{
                $total = getCartSubtotal();
                $discount = 0.00 ;
                $discountType = '';
                return response()->json(['status'=>'success','discount'=>$discount ,'total'=>$total,'discountType'=>$discountType]);
            }
        }catch(\Exception $ex){
            return response()->json(['status'=>'error','message'=>$ex->getMessage()]);
        }
    }

}
