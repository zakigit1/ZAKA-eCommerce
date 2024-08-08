<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $addresses = UserAddress::where('user_id',Auth::user()->id)->get();
        return view('Frontend.user.Dashboard.address.index',compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Frontend.user.Dashboard.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required' ,'max:200'],
            'email'=>['required','max:200','email'],
            'phone'=>['required','max:200'],
            'country'=>['required','max:200'],
            'state'=>['required','max:200'],
            'city'=>['required','max:200'],
            'zip'=>['required','max:200'],
            'address'=>['required','max:200'],
        ]);
        
        // dd($request->all());

        try{

            $userAddress = UserAddress::create([
                'user_id'=> Auth::user()->id,
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'country'=>$request->country,
                'state'=>$request->state,
                'city'=>$request->city,
                'zip'=>$request->zip,
                'address'=>$request->address,
            ]);
            
            toastr('Created Successfully !','success','Success');
            return redirect()->route('user.address.index');

        }catch(\Exception $ex){

            toastr('Has Not Been Created !','error','Error');
            return redirect()->route('user.address.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $address = UserAddress::find($id);

        if(!$address){
            toastr()->error( 'User Address is not found!');
            return to_route('user.address.index');
        }
        return view('Frontend.user.Dashboard.address.edit',compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>['required' ,'max:200'],
            'email'=>['required','max:200','email'],
            'phone'=>['required','max:200'],
            'country'=>['required','max:200'],
            'state'=>['required','max:200'],
            'city'=>['required','max:200'],
            'zip'=>['required','max:200'],
            'address'=>['required','max:200'],
        ]);
        
        // dd($request->all());

        try{
            $address = UserAddress::find($id);

            if(!$address){
                toastr()->error( 'User Address is not found!');
                return to_route('user.address.index');
            }

            $updateAddress = $address->update($request->except(['_token','_method']));
            
            toastr('Created Successfully !','success','Success');
            return redirect()->route('user.address.index');

        }catch(\Exception $ex){

            toastr('Has Not Been Created !','error','Error');
            return redirect()->route('user.address.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $userAddress = UserAddress::find($id);

            if(!$userAddress){
                toastr()->error( 'User Address is not found!');
                return to_route('user.address.index');
            }

        

            $userAddress->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>" Deleted Successfully !"]);

        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
