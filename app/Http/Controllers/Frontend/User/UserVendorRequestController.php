<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVendorRequestController extends Controller
{


    use imageUploadTrait;

    const FOLDER_PATH = '/Uploads/images/';
    const FOLDER_NAME = 'vendors';


    public function index(){
        return view('Frontend.user.Dashboard.vendor-request.index');
    }


    public function store(Request $request){
        // dd($request->all());

        $request->validate([
            'banner' => ['required','image','max:3000'],
            'shop_name' => 'required|max:200',
            'shop_email' => 'required|email',
            'shop_phone' => 'required',
            'shop_address' => 'required',
        ]);


        try{

            $vendorExist = Vendor::where('user_id',Auth::user()->id)->first();

            if($vendorExist){
                toastr('You Are Already Submitted.Please Wait Still The Admin Approve You!','error','Error');
                return redirect()->back();
            }


            $bannerName = $this->uploadImage_Trait($request ,'banner' ,self::FOLDER_PATH ,self::FOLDER_NAME);




            $vendor = Vendor::create([
                'banner' => $bannerName,
                'shop_name' => $request->shop_name,
                'phone' => $request->shop_phone,
                'email' => $request->shop_email,
                'address' => $request->shop_address,
                'description' => $request->about,
                'user_id' => Auth::user()->id,
                'status' => 0,
            ]);
    
            toastr('Submitted Successfully.Please Wait For Approve!','success','Success');
            return redirect()->back();
            
        }catch(\Exception $e){
            
            // toastr($e->getMessage(),'error','Error');
            toastr('Somthing Is Wrong','error','Error');
            return redirect()->back();
        }





    }
}
