<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;


use App\Models\Brand;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class AdminController extends Controller
{

    private const FOLDER_PATH ='/Uploads/images/';
    private const FOLDER_NAME ='profiles';



    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['todaysOrders'] = Order::whereDate('created_at',Carbon::today())
            ->count();

        $data['todaysPendingOrders'] = Order::whereDate('created_at',Carbon::today())
            ->where('order_status' ,'pending')
            ->count();

        $data['totalOrders'] = Order::count();
    
        $data['totalPendingOrders'] = Order::where('order_status' , 'pending')
            ->count();
    
        $data['totalCompleteOrders'] = Order::where('order_status' , 'delivered')
            ->count();
        
        $data['totalCanceledOrders'] = Order::where('order_status' , 'canceled')
            ->count();
            
        $data['totalProducts'] = Product::count();
            

        //  in the course we do created_at instead of update_at  also sub_total instead of amount 
        $data['todayEarning'] = Order::where('order_status' , '!=','canceled')
            ->where('payment_status',1)
            ->whereDate('updated_at',Carbon::today())
            // ->sum('sub_total');
            ->sum('amount');

        $data['monthEarning'] = Order::where('order_status' , '!=','canceled')
            ->where('payment_status',1)
            ->whereMonth('updated_at',Carbon::now()->month)
            // ->sum('sub_total');
            ->sum('amount');

        $data['yearEarning'] = Order::where('order_status' , '!=','canceled')
            ->where('payment_status',1)    
            ->whereYear('updated_at',Carbon::now()->year)
            // ->sum('sub_total');
            ->sum('amount');

        $data['totalEarning'] = Order::where('order_status' , '!=','canceled')
            ->where('payment_status',1)
            // ->sum('sub_total');
            ->sum('amount');


        $data['totalReview'] =  ProductReview::count();
        
        $data['totalBrand'] =  Brand::count();
        
        $data['totalCategory'] =  Category::count() + Subcategory::count() + Childcategory::count()  ;
        
        $data['totalBlog'] =  Blog::count();
        
        $data['totalSubscriber'] =  NewsletterSubscriber::count();
        
        $data['totalVendor'] =  User::where('role','vendor')->count();

        $data['totalUser'] =  User::where('role','user')->count();
 



        return view('admin.Dashboard.dashboard',$data);
    }


    public function login(){
        return view('admin.auth.login');
    }


    public function loginCheck(LoginRequest $request){

        $request->authenticate();

        $request->session()->regenerate();

        // if the user or vendor has been banned form the website (status is inactive)
        if($request->user()->status == 'inactive'){

            Auth::guard('web')->logout();
            $request->session()->regenerateToken();

            toastr('Account Has Been Banned From Website. Please Contact The Support !','error','Account Banned!');
            return redirect('/');
        }

        if($request->user()->role ==='admin'){
            ## The same methods
            return redirect()->route('admin.dashboard');
        }
        
        Auth::guard('web')->logout();
        $request->session()->regenerateToken();
        toastr('You are not authorized to access this page','error');
        return redirect('/');
    }


    public function profile(){


        return view('admin.Dashboard.profile.index');
    }

    // public function update_profile(UpdateAdminProfileRequest $request){
    public function update_profile(Request $request){
        // return $request;

        $request->validate([
            'name'=>'required|max:100',
            'email'=>['required','email','unique:users,email,'.Auth::user()->id],
            'image'=>['image',/*'max:2048'*/]
        ]);

        $user = Auth::user();

        if($request->hasFile('image')){

            $role = $user->role;
            $old_image = $user->image;

            // delete the old image
            deleteImage($old_image);
            
            // store the new image in storage folder
            
            // $imageName= uploadImageNew($request->image,'/Uploads/images/profiles/',$role);
            $imageName= uploadImageNew($request->image,self::FOLDER_PATH,self::FOLDER_NAME);

            ## Save Image In To DataBase : 
            $user->image = $imageName;
        }

        $user->name = $request->name;
        $user->email = $request->email;
       
        $user->save();

        toastr()->success('update profile successfully !');
        
        return redirect()->back();

    }
    // public function update_profile_password(UpdateAdminProfilePasswordRequest $request){
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
        return redirect('/admin/dashboard');

    }





}
