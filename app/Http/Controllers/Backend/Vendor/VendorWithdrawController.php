<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\DataTables\VendorWithdrawDataTable;
use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\WithdrawMethod;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VendorWithdrawController extends Controller
{
    public function index(VendorWithdrawDataTable $dataTable)
    {

        $currentBalance = $this->currentBalance();

        $totalWithdraw = WithdrawRequest::where('status','paid')->sum('total_amount');

        $pendingWithdraw = WithdrawRequest::where('status','pending')->sum('total_amount');

        return $dataTable->render('vendor.withdraw.index',compact('currentBalance','pendingWithdraw','totalWithdraw'));
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

            /** you can't ask to withdraw money bigger Or lesس than the payout range of withdraw mehtod you choose it */
            if($request->total_amount < $withdrawMethod->minimum_amount || $request->total_amount > $withdrawMethod->maximum_amount){
               throw ValidationException::withMessages(["the total amount have to be greater than ". currencyIcon().$withdrawMethod->minimum_amount." and
               less than ". currencyIcon().$withdrawMethod->maximum_amount ]);
            }

            /** you can't asked to withdraw money bigger than you have in current balance(drhm l3ndak mal mbi3at twak man orders lb3thom) */
            if($request->total_amount > $this->currentBalance()){
               throw ValidationException::withMessages(["You amount request is bigger than current balance."]);
            }

            /** 
             * if you request to withdraw money and you already asked and you have not been answered from the admin (pending) you need 
             * to wait until the withdrawal request is answered.
            */
            if(WithdrawRequest::where(['vendor_id' => Auth::user()->vendor->id , 'status' => 'pending'])->exists()){
               throw ValidationException::withMessages([
                    "You previous amount request is stil pending you can\'t add new request now.Wait until the withdrawal request is answered!"
                ]);
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

    protected function currentBalance()
    {
        $totalEarning = OrderProduct::where("vendor_id", Auth::user()->vendor->id)
        ->whereHas('order',function($q){
            $q->where('payment_status',1)->where('order_status','delivered');
        })
        ->sum(DB::raw('unit_price * qty'));

        $totalWithdraw = WithdrawRequest::where('status','paid')->sum('total_amount');
        
        $currentBalance = $totalEarning - $totalWithdraw;

        return $currentBalance;
    }
}
