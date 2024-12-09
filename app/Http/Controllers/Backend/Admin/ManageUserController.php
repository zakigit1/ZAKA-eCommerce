<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\AccountCreatedMail;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ManageUserController extends Controller
{

    public function index(){
        return view('admin.manage-user.index');
        
    }
    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20|confirmed',
            'role' => 'required'
        ]);

        try{   
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'status' => 'active',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

            if($user->role == "vendor" || $user->role == "admin" ){

                Vendor::create([
                    'banner' => 'banner-default.jpg',
                    'shop_name' => $user->name.' shop',
                    'phone' => '+213 0778797472',
                    'email' => 'test@gmail.com',
                    'address' => 'USA',
                    'description' => 'shop description',
                    'status' => 1,
                    'user_id' => $user->id
                ]);
            }

            //Set Mail Configuration
            MailHelper::setMailConfig();


            Mail::to($user->email)->send(new AccountCreatedMail($user->name,$user->email,$user->password));

            toastr("The New $request->role Has Been Created Successfully",'success','Success');
            DB::commit();
            return redirect()->back();

        }catch(\Exception $ex){
            DB::rollBack();
            toastr($ex->getMessage(),'error','Error!');
            return redirect()->back();
        }



    }


}
