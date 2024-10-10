<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index(){
        $generalSetting = GeneralSetting::first();
        $emailConfig = EmailConfiguration::first();
        return view('admin.setting.index',compact('generalSetting','emailConfig'));
    }

    public function UpdateSettingsGeneral(Request $request){

        $request->validate([
            'site_name'=>'required|max:200',
            'layout'=>'required|max:200',
            'contact_email'=>'required|max:200',
            
            'contact_phone'=>'nullable',
            'contact_address'=>'nullable',
            'contact_map'=>'nullable|url',
            
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

                    'contact_phone'=>$request->contact_phone,
                    'contact_address'=>$request->contact_address,
                    'contact_map'=>$request->contact_map,

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


    public function UpdateEmailConfiguration(Request $request){

        $request->validate([
            'email'=>'required|email|max:200',
            'host'=>'required|max:200',
            'username'=>'required|max:200',
            'password'=>'required|max:200',
            'port'=>'required|max:200',
            'encryption'=>'required|in:tls,ssl',
        ]);
        // dd($request->all());

        try{   
            $emailConfig = EmailConfiguration::updateOrCreate(
                ['id'=> 1],
                [
                    'email'=>$request->email,
                    'host'=>$request->host,
                    'username'=>$request->username,
                    'password'=>$request->password,
                    'port'=> $request->port,
                    'encryption'=>$request->encryption,
                ]
            );

            toastr('Email Configuration Has Been Updated Successfully !','success','Success');
            return redirect()->back();

        }catch(\Exception $ex){

            toastr('Email Configuration Has Not Been Updated Successfully !','error','Error');
            return redirect()->back();
        }

    }


    public function changeViewList(Request $request){
        Session::put('settings_view_list',$request->style);
    }
}
