<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminVendroProfileController extends Controller
{
    use imageUploadTrait;

    const FOLDER_PATH = '/Uploads/images/';
    const FOLDER_NAME = 'vendors';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile=Vendor::where('user_id',Auth::user()->id)->first();
        return view('admin.vendor-profile.index',compact('profile'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function update_admin_vendor_profile(Request $request)
    {
        $request->validate([
            'banner'=>'image',
            'shop_name'=>'required|max:500',
            'phone'=>'required|max:50',
            'email'=>'required|email|max:200',
            'address'=>'required',
            'description'=>'required',
            'fb_link'=>'nullable|url',
            'tw_link'=>'nullable|url',
            'insta_link'=>'nullable|url',
        ]);
        // dd($request->all());

        try{

            DB::beginTransaction();
            $vendor=Vendor::where('user_id',Auth::user()->id)->first();

            $old_banner = $vendor->banner;

            
            if($request->hasFile('banner')){
                $bannerName=$this->updateImage_Trait($request,'banner',self::FOLDER_PATH,self::FOLDER_NAME,$old_banner);

                $vendor->update([
                    'banner'=>$bannerName,
                ]);
            }

            $vendor->update([
                // 'banner'=>empty(!$bannerName) ? $bannerName : $old_banner,
                'shop_name'=>$request->shop_name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'address'=>$request->address,
                'description'=>$request->description,
                'fb_link'=>$request->fb_link,
                'tw_link'=>$request->tw_link,
                'insta_link'=>$request->insta_link,
            ]);

            DB::commit();
            toastr('Admin Vendor Profile Updated Successefully ', 'success');
            return redirect()->back();

        }catch(\Exception $ex){
            DB::rollBack();
            toastr('Admin Vendor Profile Update Failed', 'error');
            return redirect()->back();
        }
    }    
}
