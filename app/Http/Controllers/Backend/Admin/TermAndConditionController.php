<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermAndCondition;
use Illuminate\Http\Request;

class TermAndConditionController extends Controller
{
    public function index(){
        
        $termAndCondition = TermAndCondition::first();
        return view('admin.term-and-condition.index',compact('termAndCondition'));
        
    }
    public function updateTermsAndConditions(Request $request){

        $request->validate([
            'termsandconditions_content'=>'required'
        ]);


        $update = TermAndCondition::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->termsandconditions_content,
            ]
        );

        toastr('Terms & Conditions Content Has Been Updated Successfully!','success', 'Success');

        return redirect()->back();
    }
}
