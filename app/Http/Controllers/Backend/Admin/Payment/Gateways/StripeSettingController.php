<?php

namespace App\Http\Controllers\Backend\Admin\Payment\Gateways;

use App\Http\Controllers\Controller;
use App\Models\StripeSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StripeSettingController extends Controller
{
    public function updateStripeSettings(Request $request)
    {

       try{    
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

        
            StripeSetting::updateOrCreate(
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

            toastr('Stripe Settings Has Been Updated Successfully !','success','Success');
            return redirect()->back();

        } catch (ValidationException $e) {
            toastr()->error($e->getMessage(),'Stripe Settings Validation Error');
            return redirect()->back();
        }catch(\Exception $ex){
            toastr($ex->getMessage(),'error','Stripe Settings Error');
            // toastr('Stripe Settings Has Not Been Updated Successfully !','error','Error');
            return redirect()->back();
        }
    }
}
