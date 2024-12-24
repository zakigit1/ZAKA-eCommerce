<?php

namespace App\Http\Controllers\Backend\Admin\Withdraw;

use App\DataTables\WithdrawRequestListDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class WithdrawRequestListController extends Controller
{
    public function index(WithdrawRequestListDataTable $dataTable)
    {
        return $dataTable->render('admin.withdraw.withdraw-request-list.index');
    }


    public function show(string $id){

        $withdrawRequest = WithdrawRequest::with('vendor')->find($id);

        if(!$withdrawRequest){
            toastr()->error( 'Withdraw request is not found!');
            return redirect()->back();
        }

      
        return view('admin.withdraw.withdraw-request-list.show',compact('withdrawRequest'));
    }



    public function withdraw_request_change_status(Request $request){

        $request->validate([
            'id' => 'required|integer|exists:withdraw_requests,id',
            'status' =>'required|in:pending,paid,decline',
        ]);



        $withdrawRequest = WithdrawRequest::find($request->id);
 
         if(!$withdrawRequest){
            return response(['status'=>'error','message'=>"Withdraw request is not found!"]);
         }
         
        $withdrawRequest->status = $request->status;
        $withdrawRequest->save();
 
        return response(['status'=>'success','message'=>"Update Withdraw Request Status"]);
    }
}
