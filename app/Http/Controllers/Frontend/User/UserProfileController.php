<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index(){

        return view('frontend.user.Dashboard.profile');
    }

    // public function update_profile(UpdateUserProfileRequest $request){
    public function update_profile(Request $request){
        // return dd($request->all()); this is good 

        $request->validate([
            'name'=>'required|max:100',
            'email'=>['required','email','unique:users,email,'.Auth::user()->id],
            'image'=>['image',/*'max:2048'*/]
        ]);

        $user = Auth::user();

        if($request->hasFile('image')){

            $role = $user->role;//user
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
        return redirect('/user/dashboard');

    }
}
