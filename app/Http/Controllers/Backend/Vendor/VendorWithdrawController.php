<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\DataTables\VendorWithdrawDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawMethod;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VendorWithdrawController extends Controller
{
    public function index(VendorWithdrawDataTable $dataTable)
    {
        return $dataTable->render('vendor.withdraw.index');
    }


    public function create()
    {
        $withdrowMethods = WithdrawMethod::all(['id','name']);
        // dd($withdrowMethods);
        return view('vendor.withdraw.create',compact('withdrowMethods'));
    }


    public function store(Request $request)
    {
        try{
            // return $request->all();
            $request->validate([
                'withdraw_method_id' => 'required|exists:withdraw_methods,id',
                'total_amount' => 'required|numeric',
                'account_information' => 'required|max:2000',
            ]);


            $withdrawMethod = WithdrawMethod::where('id',$request->withdraw_method_id)->first();
            
            if(!$withdrawMethod){
                toastr('Withdraw Method Not Found !','error','Error');
                return redirect()->route('vendor.withdraw.index');
            }

            if($request->total_amount < $withdrawMethod->minimum_amount || $request->total_amount > $withdrawMethod->maximum_amount){
               throw ValidationException::withMessages(["the total amount have to be greater than ". currencyIcon().$withdrawMethod->minimum_amount." and
               less than ". currencyIcon().$withdrawMethod->maximum_amount ]);
            }


            $withdrawRequest = new WithdrawRequest();

            $withdrawRequest->vendor_id = Auth::user()->vendor->id ;
            $withdrawRequest->withdraw_method_id = $request->withdraw_method_id ;

            $withdrawRequest->total_amount = $request->total_amount ;
            $withdrawRequest->withdraw_amount = $request->total_amount - (($request->total_amount * $withdrawMethod->withdraw_charge) / 100) ;
            $withdrawRequest->withdraw_charge = (($request->total_amount * $withdrawMethod->withdraw_charge) / 100) ;
            $withdrawRequest->account_information = $request->account_information ;
            $withdrawRequest->status = 'pending' ;
            $withdrawRequest->save() ;

            toastr('Withdraw Request Has Been Created Successfully!','success','Success');
            return redirect()->route('vendor.withdraw.index');



        }catch(\Exception $e){
            toastr($e->getMessage(),'error','Error');
            // toastr('Something went wrong, please try again later.','error','Error');
            return redirect()->route('vendor.withdraw.index');
        }
    }

    public function withdrawMethodDetails(string $id)
    {
        $withdrawMethod = WithdrawMethod::find($id);

        if(!$withdrawMethod){
            return response(['status'=>'error','message'=>'Withdraw Method Not Found !']);
        }


        return response(['withdrawMethod'=> $withdrawMethod]);

    }

    public function show(string $id)
    {
        $withdrawRequest = WithdrawRequest::with('method')->where('vendor_id',Auth::user()->vendor->id)->find($id);
        if(!$withdrawRequest){
            toastr('Withdraw Request Not Found','error','Error');
            return redirect()->route('vendor.withdraw.index');
        }

        return view('vendor.withdraw.show',compact('withdrawRequest'));
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
