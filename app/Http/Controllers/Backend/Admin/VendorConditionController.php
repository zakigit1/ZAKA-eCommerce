<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorCondition;
use Illuminate\Http\Request;

class VendorConditionController extends Controller
{
    public function index(){
        
        $vendor_condition = VendorCondition::first();
        return view('admin.vendor-condition.index',compact('vendor_condition'));
    }
    public function updateVendorCondition(Request $request){

        $request->validate([
            'condition_content'=>'required'
        ]);


        $update = VendorCondition::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->condition_content,
            ]
        );

        toastr('Vendor Condition Has Been Updated Successfully!','success', 'Success');

        return redirect()->back();
    }
}
