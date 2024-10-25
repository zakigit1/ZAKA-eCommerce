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


    public function withdraw_request_change_status(Request $request){
        $withdrawRequest = WithdrawRequest::find($request->id);
 
         if(!$withdrawRequest){
             toastr()->error( 'Withdraw request is not found!');
             return redirect()->back();
         }
         
        $withdrawRequest->status = $request->value;
        $withdrawRequest->save();
 
        return response(['status'=>'success','message'=>"Update Withdraw Request Status"]);
     }
}
