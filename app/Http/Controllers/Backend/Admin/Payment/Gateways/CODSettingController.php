<?php

namespace App\Http\Controllers\Backend\Admin\Payment\Gateways; 

use App\Http\Controllers\Controller;
use App\Models\CODSetting;
use Illuminate\Http\Request;

class CODSettingController extends Controller
{
    public function UpdateCODSettings(Request $request){

        $request->validate([
            "status"=> "required|boolean",
        ]);

    
        try{   
            $codSettings = CODSetting::updateOrCreate(
                ['id'=> 1],
                [
                    'status' => $request->status,
                ]
            );

            toastr('COD Settings Has Been Updated Successfully !','success','Success');
            return redirect()->back();

        }catch(\Exception $ex){

            toastr($ex->getMessage(),'error');
            // toastr('COD Settings Has Not Been Updated Successfully !','error','Error');
            return redirect()->back();
        }

    }
}
