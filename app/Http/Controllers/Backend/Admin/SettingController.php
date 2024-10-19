<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class SettingController extends Controller
{

    use imageUploadTrait;

    const FOLDER_PATH = '/Uploads/images/';
    const FOLDER_NAME = 'logoAndfavicon';


    public function index(){
        $generalSetting = GeneralSetting::first();
        $emailConfig = EmailConfiguration::first();
        $logoSettings = LogoSetting::first();
        return view('admin.setting.index',compact('generalSetting','emailConfig','logoSettings'));
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
            // toastr($ex->getMessage() ,'error','Error');
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
            // toastr($ex->getMessage() ,'error','Error');
            toastr('Email Configuration Has Not Been Updated Successfully !','error','Error');
            return redirect()->back();
        }

    }


    public function UpdateLogaAndFavicon(Request $request){

        $request->validate([
            'logo'=>'image',
            'favicon'=>'image',
        ]);

        // dd($request->all());

        
        try{   

            $logoCheck = LogoSetting::first(); 

            if(!$request->hasFile('logo') &&  !$request->hasFile('favicon') ){
                
                if($logoCheck == null){

                    toastr('You Must To Enter Logo & Favicon For Your Site !','error','Error');
                    return redirect()->back();
                    
                }
                toastr('You Need At Leaste Enter One Logo To Update !','error','Error');
                return redirect()->back();
            }


            $oldLogo = $logoCheck?->logo;            
            $imageUpdatedLogo= $oldLogo ;

            $oldFavicon = $logoCheck?->favicon;
            $imageUpdatedFavicon= $oldFavicon ;
            
            

            if($request->hasFile('logo') || $request->hasFile('favicon')){

                if($request->hasFile('logo')){
                    $imageUpdatedLogo = $this->updateImage_Trait($request,'logo',self::FOLDER_PATH,self::FOLDER_NAME,$imageUpdatedLogo);
                }else{
                    $imageUpdatedLogo = basename($imageUpdatedLogo);
                }

                if($request->hasFile('favicon')){
                    $imageUpdatedFavicon = $this->updateImage_Trait($request,'favicon',self::FOLDER_PATH,self::FOLDER_NAME,$imageUpdatedFavicon);
                }else{
                    $imageUpdatedFavicon = basename($imageUpdatedFavicon);
                }

            }

            // dd($imageUpdatedFooterLogo."||||||||".$imageUpdatedLogo."||||||||".$imageUpdatedFavicon);
           

            $logoAndfavicon = LogoSetting::updateOrCreate(
                ['id'=> 1],
                [
                    'logo'=>$imageUpdatedLogo,
                    'favicon'=>$imageUpdatedFavicon,
                ]
            );

            toastr('Logo & Favicon Has Been Updated Successfully !','success','Success');
            return redirect()->back();

        }catch(\Exception $ex){

            toastr($ex->getMessage() ,'error','Error');
            // toastr('Logo & Favicon Has Not Been Updated Successfully !','error','Error');
            return redirect()->back();
        }



    }








    public function changeViewList(Request $request){
        Session::put('settings_view_list',$request->style);
    }
}
