<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['todaysOrders'] = Order::whereDate('created_at',Carbon::today())
            ->whereHas('orderProducts',function($q){
                $q->where('vendor_id' , Auth::user()->vendor->id);
            })
            ->count();

        $data['todaysPendingOrders'] = Order::whereDate('created_at',Carbon::today())
            ->where('order_status' ,'pending')
            ->whereHas('orderProducts',function($q){
                $q->where('vendor_id' , Auth::user()->vendor->id);
            })
            ->count();

        $data['totalOrders'] = Order::whereHas('orderProducts',function($q){
                    $q->where('vendor_id' , Auth::user()->vendor->id);
                })
                ->count();
        
        $data['totalPendingOrders'] = Order::where('order_status' , 'pending')
                ->whereHas('orderProducts',function($q){
                    $q->where('vendor_id' , Auth::user()->vendor->id);
                })
                ->count();
        
        $data['totalCompleteOrders'] = Order::where('order_status' , 'delivered')
                ->whereHas('orderProducts',function($q){
                    $q->where('vendor_id' , Auth::user()->vendor->id);
                })
                ->count();
                
        $data['totalProducts'] =Product::where('vendor_id' , Auth::user()->vendor->id)->count();
                
        

        //  in the course we do created_at instead of update_at  also sub_total instead of amount 
        $data['todayEarning'] = Order::where('order_status' , 'delivered')
                ->whereDate('updated_at',Carbon::today())
                ->whereHas('orderProducts',function($q){
                    $q->where('vendor_id' , Auth::user()->vendor->id);
                })
                // ->sum('sub_total');
                ->sum('amount');

        $data['monthEarning'] = Order::where('order_status' , 'delivered')
                ->whereMonth('updated_at',Carbon::now()->month)
                ->whereHas('orderProducts',function($q){
                    $q->where('vendor_id' , Auth::user()->vendor->id);
                })
                // ->sum('sub_total');
                ->sum('amount');

        $data['yearEarning'] = Order::where('order_status' , 'delivered')
                ->whereYear('updated_at',Carbon::now()->year)
                ->whereHas('orderProducts',function($q){
                    $q->where('vendor_id' , Auth::user()->vendor->id);
                })
                // ->sum('sub_total');
                ->sum('amount');

        $data['totalEarning'] = Order::where('order_status' , 'delivered')
                ->whereHas('orderProducts',function($q){
                    $q->where('vendor_id' , Auth::user()->vendor->id);
                })
                // ->sum('sub_total');
                ->sum('amount');


        $data['totalReview'] =  ProductReview::whereHas('product',function($q){
                    $q->where('vendor_id' , Auth::user()->vendor->id);
                })
                ->count();
              





        return view('vendor.Dashboard.dashboard',$data);
    }

    public function profile(){

        return view('vendor.Dashboard.profile');
    }

// public function update_profile(UpdateVendorProfileRequest $request){
    public function update_profile(Request $request){
        // return dd($request->all()); this is good 

        $request->validate([
            'name'=>'required|max:100',
            'email'=>['required','email','unique:users,email,'.Auth::user()->id],
            'image'=>['image',/*'max:2048'*/]
        ]);

        $user = Auth::user();

        if($request->hasFile('image')){

            $role = $user->role;//vendor
            $old_image = $user->image;

            // delete the old image
            deleteImage($old_image);
            
            // store the new image in storage folder
            // $imageName= uploadImageNew($request->image,'/Uploads/images/profiles');
            $imageName= uploadImageNew($request->image,'/Uploads/images/profiles/',$role);

            ## Save Image In To DataBase : 
            $user->image=$imageName;
        }

        $user->name=$request->name;
        $user->email=$request->email;
    
        $user->save();

        toastr()->success('update profile successfully !');
        
        return redirect()->back();

    }
    // public function update_profile_password(UpdateVendorProfilePasswordRequest $request){
    public function update_profile_password(Request $request){
    
        
        $request->validate([
            'current_password' => ['required','current_password'],
            'password' => ['required','min:8','confirmed']
        ]);

    
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        // $user->password = bcrypt($request->password);
        $user->save();

        ##
        // $request->user()->update([
        //     'password'=>Hash::make($request->password),
        // ]);
        
        toastr()->success('Profile Password Updated Successfully !');
        return redirect('/vendor/dashboard');

    }



}
