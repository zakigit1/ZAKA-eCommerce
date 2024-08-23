<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index(){

        $userAdresses = UserAddress::where('user_id',Auth::user()->id)->get();
        $shippingMethods = ShippingRule::where('status', 1)->get();
        return view('Frontend.store.pages.checkout',compact('userAdresses','shippingMethods'));
    }

    public function createAddress(Request $request){
        
        
        
        $request->validate([
            'name'=>['required' ,'max:200'],
            'email'=>['required','max:200','email'],
            'phone'=>['required','max:200'],
            'country'=>['required','max:200'],
            'state'=>['required','max:200'],
            'city'=>['required','max:200'],
            'zip'=>['required','max:200'],
            'address'=>['required','max:200'],
        ]);
        
        // dd($request->all()); 

        try{

            $userAddress = UserAddress::create([
                'user_id'=> Auth::user()->id,
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'country'=>$request->country,
                'state'=>$request->state,
                'city'=>$request->city,
                'zip'=>$request->zip,
                'address'=>$request->address,
            ]);
            
            toastr('Created Successfully !','success','Success *');
            return redirect()->route('user.checkout');

        }catch(\Exception $ex){

            toastr('Has Not Been Created !','error','Error *');
            return redirect()->route('user.checkout');
        }


        
    }

    public function checkoutSubmit(Request $request){
        $request->validate([
            'shipping_method_id'=>['required','integer','exists:shipping_rules,id'],
            'shipping_address_id'=>['required','integer','exists:user_addresses,id'],
        ]);
        
        // dd($request->all());
        
        $shippingMethod = ShippingRule::findOrFail($request->shipping_method_id);

        if($shippingMethod){//for more securite

            Session::put('shipping_method',[
                'id'=>$shippingMethod->id,
                'name'=>$shippingMethod->name,
                'type'=>$shippingMethod->type,
                'cost'=>$shippingMethod->cost,
            ]);
        }
        // dd($shippingMethod);
        
        $shippingUserAddress = UserAddress::findOrFail($request->shipping_address_id)->toArray();

        if($shippingUserAddress){
            Session::put('address',$shippingUserAddress);
        }


        return response()->Json(['status'=>'success','redirect_url'=>route('user.payment')]);
    }
}
