<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CODSetting;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaypalSetting;
use App\Models\Product;
use App\Models\StripeSetting;
use App\Models\Transaction;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index(){

        if(!Session::has('address')){
            return redirect()->route('user.checkout');
        }

        return view('Frontend.store.pages.payment.index');
    }


    public function paymentSuccess(){
        return view('Frontend.store.pages.payment.payment-success');
    }

    public function clearSession (){
        Cart::destroy();
        
        Session::forget('address');
        Session::forget('shipping_method');

        if(Session::has('coupon')){ // just for protection 
            Session::forget('coupon');
        }
    }



    //######################################### Paypal Gatway Start  #########################################\\


    public function storeOreder($paymentMethod ,$paymentStatus ,$transactionId ,$paidAmount ,$paidCurrencyName) {
        

        /** Store Order :  */

        $generalSettings =GeneralSetting::first();

        $order = new Order();

        $order->invoice_id = rand(1 ,9999999) ; 
        $order->user_id = Auth::user()->id; 
        $order->sub_total = getCartSubtotal() ; // the total price of product mines coupon
        $order->amount = finalAmount(); // the total price of product mines coupon plus shipping fee
        $order->currency_name = $generalSettings->currency_name; 
        $order->currency_icon = $generalSettings->currency_icon; 
        $order->product_qty = Cart::content()->count(); 
        $order->payment_method = $paymentMethod; 
        $order->payment_status= $paymentStatus; 
        $order->order_address=json_encode(Session::get('address')); 
        $order->shipping_method= json_encode(Session::get('shipping_method')); 
        $order->coupon=json_encode(Session::get('coupon')); 
        $order->order_status= 'pending'; //default 0
        $order->save(); 
        
        /** Store Order Products :  */ 
        
        foreach(Cart::content() as $item){

            $product = Product::find($item->id);

            $orderProduct = new OrderProduct(); 
            $orderProduct->order_id = $order->id ; 
            $orderProduct->product_id = $product->id; //or $item->id (same)
            $orderProduct->vendor_id = $product->vendor_id; 
            $orderProduct->product_name = $product->name ;
            $orderProduct->variants = json_encode($item->options->variants) ;
            $orderProduct->variant_total = $item->options->variants_total_amount;
            $orderProduct->unit_price = $item->price;
            $orderProduct->qty = $item->qty ;            
            $orderProduct->save(); 
        }

        /** Store tansaction details  :  */ 

        $orderProduct = new Transaction();
        $orderProduct->order_id = $order->id ; 
        $orderProduct->transaction_id = $transactionId; 
        $orderProduct->payment_method = $paymentMethod ;  
        $orderProduct->amount = finalAmount(); 
        $orderProduct->amount_real_currency = $paidAmount; //finalAmount() * currency_rate 
        $orderProduct->amount_real_currency_name = $paidCurrencyName; 
        $orderProduct->save(); 

    }

    public function paypalConfigration(){

        $paypalSetting = PaypalSetting::first() ;

        $config = [
            'mode'    => $paypalSetting->mode , // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => $paypalSetting->client_id,
                'client_secret'     => $paypalSetting->secret_key,
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => $paypalSetting->client_id,
                'client_secret'     => $paypalSetting->secret_key,
                'app_id'            => '',
            ],
        
            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => $paypalSetting->currency_name,
            'notify_url'     => '', // Change this accordingly for your application.
            'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => True, // Validate SSL when creating api client.
        ];

        return $config;
    }



    public function paypalPayment(){

        $paypalSetting = PaypalSetting::first() ;

        $config = $this->paypalConfigration();
        // dd($config);
        
        /**
         * Calculate Paypal Amount depending to currency rate exp : DA  -> USD  or Euro to USD: 
        */

            $paidAmountfinal = $this->paidAmount($paypalSetting);
            // dd($totalAmountFinal);


        $provider = new PayPalClient($config);
        $paypalToken = $provider->getAccessToken();

        /* 
            ! this method of doc is not working  :

            $provider = new PayPalClient;
            $paypalToken = $provider->getAccessToken();
            $provider->setApiCredentials($config);
        */ 

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                
                "return_url" => route('user.paypal.success'),// when user information is correct we redirect user to this route 
                "cancel_url" => route('user.paypal.cancel'),  
            ],
            "purchase_units"=>[
                [
                    "amount" => [
                        "currency_code" => $config['currency'],
                        "value"=> $paidAmountfinal 
                    ]
                ]
            ]
        ]);

        // dd($response);

        if(isset($response['id']) && $response['id'] != null){
            foreach($response['links'] as $link){
                if($link['rel'] == 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else{
            toastr('Something wrong in the first step of paypal payment try again','error','Error in payment with Paypal Gatways!');
            return to_route('user.paypal.cancel');
        }

    }


    // public function success(Request $request){

    //     // dd($request->all());

    //     /**
    //      * Paypal Configration :
    //     */

    //     $config = $this->paypalConfigration();
    //     // dd($config['currency']);

    //     $provider = new PayPalClient($config);
    //     $paypalToken = $provider->getAccessToken();


    //     $response = $provider->capturePaymentOrder($request->token);
        
    //     dd($response);


    //     if(isset($response['status'])&& $response['status']=="COMPLETED"){
            
    //        // in real project you do like insert data to database or updating data (ki twil tst3mlah fl real project )

    //         return 'Paid Successfully ';
    //     }


    //     return redirect()->route('user.paypal.cancel');
    //     // return redirect('user/paypal/cancel');

    // }



    public function success(Request $request)
    {
        try {

            $config = $this->paypalConfigration();
            $provider = new PayPalClient($config);
            $paypalToken = $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request->token);

            // dd($response);

            if (isset($response['status']) && $response['status'] == "COMPLETED") {

                /** Store Order :  */
                $transactionId = $response['id'];
                $paymentMethod ='paypal';
                $paymentStatus = 1 ;
                
                $paypalSetting = PaypalSetting::first() ;   

                // Calculate Stripe Amount depending to currency rate exp : DA  -> USD  or Euro to USD: 
                $paidAmountfinal= $this->paidAmount($paypalSetting);


                $paidCurrencyName  = $paypalSetting->currency_name;

                $this->storeOreder($paymentMethod ,$paymentStatus ,$transactionId ,$paidAmountfinal ,$paidCurrencyName);

                /** Clear Session : */
                $this->clearSession();


                toastr('Payment completed successfully','success'); 
                return redirect()->route('user.payment.success');

            }else {
                toastr('Payment was not completed','error','Error in payment with Paypal Gatways!'); 
                return redirect()->route('user.paypal.cancel');
            }
        } catch (\Exception $e) {
            
            // toastr($e->getMessage(),'error');
            toastr('Somthing Went Wrong Try Again Later !','error','Error in payment with Paypal Gatways!');
            return redirect()->route('user.paypal.cancel');
        }
    }

    public function cancel(){

        return redirect()->route('user.payment');
    }

    //######################################### Paypal Gatway End  #########################################\\


    //######################################### stripe Gatway Start #########################################\\


    public function stripePayment(Request $request){


        try{

            // dd($request->all());
            $stripeSetting = StripeSetting::first() ;  

            // Calculate Stripe Amount depending to currency rate exp : DA  -> USD  or Euro to USD: 
            $paidAmountfinal = $this->paidAmount($stripeSetting);

            Stripe::setApiKey($stripeSetting->secret_key);



            $response = Charge::create([
                'amount' => $paidAmountfinal * 100,
                'currency' => $stripeSetting->currency_name,
                'source' => $request->stripe_token,
                'description'=> "Product Purchase!",
            ]);

            // dd($response);

            if($response->status == 'succeeded'){

                 /** Store Order : */

                $this->storeOreder('stripe' ,1 ,$response->id ,$paidAmountfinal ,$stripeSetting->currency_name);
               
                /** Clear Session : */
                $this->clearSession();


                toastr('Payment completed successfully','success'); 
                return redirect()->route('user.payment.success');

            }else {
                toastr('Payment was not completed','error','Error in payment with Stripe Gatways!'); 
                return redirect()->route('user.payment');
            }

        }catch (\Exception $e) { 
            // toastr($e->getMessage(),'error');
            toastr('Somthing Went Wrong Try Again Later !','error','Error in payment with Stripe Gatways!');
            return redirect()->route('user.payment');
        }
        
        
    }

    

    //######################################### stripe Gatway End #########################################\\
    
    
    //######################################### razorpay Gatway Start #########################################\\
    
    public function razorpayPayment(Request $request){

        dd($request->all());

        $razorpaySetting = \App\Models\RazorpaySetting::first() ;   

        $api = new Api($razorpaySetting->razorpay_key , $razorpaySetting->razorpay_secret_key);

        $paidAmountFinal = $this->paidAmount($razorpaySetting);

        // $razorpayAmountFinal = $paidAmountFinal * 100 ;

        if($request->has('razorpay_payment_id') && $request->filled('razorpay_payment_id')){
            try{

                $response = $api->payment->fetch($request->razorpay_payment_id)
                            ->capture(['amount' =>$paidAmountFinal * 100]);

            }catch(\Exception $ex){
                toastr($ex->getMessage(),'error','Error in payment with Razorpay Gatways!');
                // toastr('Somthing Went Wrong Try Again Later !','error','Error in Razorpay Gatways!');
                return redirect()->route('user.payment');
            }

            if($response['status'] == 'captured'){

                $this->storeOreder('razorpay' ,1 ,$response['id'] ,$paidAmountFinal ,$razorpaySetting->currency_name);
               
                /** Clear Session : */
                $this->clearSession();


                toastr('Payment completed successfully','success'); 
                return redirect()->route('user.payment.success');
                
            }else{
                toastr('Payment was not completed','error','Error in payment with Razorpay Gatways!'); 
                return redirect()->route('user.payment');
            }
        }

    }
    //######################################### razorpay Gatway End #########################################\\

    //######################################### razorpay Gatway Start #########################################\\
    
    public function codPayment(){

        try{
            $codSetting = CODSetting::first();   
            $Setting = GeneralSetting::first();   
    
            if($codSetting->status == 0){
                toastr('The Cach On Delivery Option Is Not Available!','success','Success');
                return redirect()->back();
            }
            
            $total = finalAmount();//this function in general file 
            $paidAmountFinal  = round( $total , 2);// you get the price in USD 
    
            $this->storeOreder('COD' ,0 ,Str::random(10) ,$paidAmountFinal ,$Setting->currency_name);
                   
            /** Clear Session : */
            $this->clearSession();
           
            toastr('Payment completed successfully','success'); 
            return redirect()->route('user.payment.success');

        }catch(\Exception $ex){
                toastr($ex->getMessage(),'error','Error in payment with Razorpay Gatways!');
                // toastr('Somthing Went Wrong Try Again Later !','error','Error in Razorpay Gatways!');
                return redirect()->route('user.payment');
        }

            





                

      

    }
    //######################################### razorpay Gatway End #########################################\\










    public function paidAmount($gatewaySettngs){
        
        // Calculate Stripe Amount depending to currency rate exp : DA  -> USD  or Euro to USD: 
            $total = finalAmount();//this function in general file 
            $paidAmount  = round( $total * $gatewaySettngs->currency_rate , 2);// you get the price in USD 
        
        return $paidAmount ;
    }







}
