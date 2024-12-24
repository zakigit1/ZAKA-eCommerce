<?php

namespace App\Http\Controllers\Backend\Admin\Payment\Gateways;

use App\Http\Controllers\Controller;
use App\Models\RazorpaySetting;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class RazorpaySettingController extends Controller
{
    public function UpdateRazorpaySettings(Request $request)
    {
        try{ 
        // dd($request->all());
        $request->validate([

            'status'=>'required|boolean',
            'country_name'=>'required|max:200',
            'currency_name'=>'required|max:200',
            'currency_rate'=>'required',
            'razorpay_key'=>'required',
            'razorpay_secret_key'=>'required',

        ]);
        // dd($request->all());

          
            RazorpaySetting::updateOrCreate(
                ['id'=> 1],
                [
                    'status' => $request->status,
                    'country_name' => $request->country_name,
                    'currency_name' => $request->currency_name,
                    'currency_rate' => $request->currency_rate,
                    'razorpay_key' => $request->razorpay_key,
                    'razorpay_secret_key' => $request->razorpay_secret_key
                ]
            );

            toastr('Razorpay Settings Has Been Updated Successfully !','success','Success');
            return redirect()->back();

        } catch (ValidationException $e) {
            toastr()->error($e->getMessage(),'Rezorpay Settings Validation Error');
            return redirect()->back();
        }catch(\Exception $ex){
            toastr($ex->getMessage(),'error','Rezorpay Settings Error');
            // toastr('Razorpay Settings Has Not Been Updated Successfully !','error','Error');
            return redirect()->back();
        }
    }
}
