<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $generalSetting = GeneralSetting::first();
        return view('admin.setting.index',compact('generalSetting'));
    }

    public function UpdateSettingsGeneral(Request $request){

        $request->validate([
            'site_name'=>'required|max:200',
            'layout'=>'required|max:200',
            'contact_email'=>'required|max:200',
            'currency_name'=>'required|max:200',
            'currency_icon'=>'required|max:200',
            'time_zone'=>'required|max:200',
        ]);
        // dd($request->all());

    try{   
         $generalSettings = GeneralSetting::updateOrCreate(
            ['id'=> 1],
            [
                'site_name'=>$request->site_name,
                'layout'=>$request->layout,
                'contact_email'=>$request->contact_email,
                'currency_name'=>$request->currency_name,
                'currency_icon'=>$request->currency_icon,
                'time_zone'=>$request->time_zone,
            ]
        );

        toastr('General Settings Has Been Updated Successfully !','success','Success');
        return redirect()->back();

    }catch(\Exception $ex){

        toastr('General Settings Has Not Been Updated Successfully !','error','Error');
        return redirect()->back();
    }

    }
}
