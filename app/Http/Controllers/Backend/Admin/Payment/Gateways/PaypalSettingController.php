<?php

namespace App\Http\Controllers\Backend\Admin\Payment\Gateways;

use App\Http\Controllers\Controller;
use App\Models\PaypalSetting;
use Illuminate\Http\Request;

class PaypalSettingController extends Controller
{
    public function updatePaypalSettings(Request $request){

        // dd($request->all());
        $request->validate([

            'status'=>'required|boolean',
            'mode'=>['required','in:sandbox,live'],
            'country_name'=>'required|max:200',
            'currency_name'=>'required|max:200',
            'currency_rate'=>'required',
            'client_id'=>'required',
            'secret_key'=>'required',

        ]);
        // dd($request->all());

        try{   
            $paypalSettings = PaypalSetting::updateOrCreate(
                ['id'=> 1],
                [
                    'status'=>$request->status,
                    'mode'=>$request->mode,
                    'country_name'=>$request->country_name,
                    'currency_name'=>$request->currency_name,
                    'currency_rate'=>$request->currency_rate,
                    'client_id'=>$request->client_id,
                    'secret_key'=>$request->secret_key
                ]
            );

            toastr('Paypal Settings Has Been Updated Successfully !','success','Success');
            return redirect()->back();

        }catch(\Exception $ex){

            toastr($ex->getMessage(),'error');
            // toastr('Paypal Settings Has Not Been Updated Successfully !','error','Error');
            return redirect()->back();
        }
    }
}
