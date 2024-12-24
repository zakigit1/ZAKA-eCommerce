<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\ApprovedVendorRequestDataTable;
use App\DataTables\PendingVendorRequestDataTable;
use App\DataTables\VendorRequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorRequestController extends Controller
{
    public function index(VendorRequestDataTable $dataTable){
        return $dataTable->render('admin.vendor-request.index');
        
    }
    public function show(string $id){

        $vendor = Vendor::find($id);

        if(!$vendor){
            toastr('Vendor Not Found!','error','Error');
            return redirect()->back();
        }

        return view('admin.vendor-request.show',compact('vendor'));
    }

    public function pendingVendorRequest(PendingVendorRequestDataTable $dataTable){
        return $dataTable->render('admin.vendor-request.status.pending');
    }
    public function ApprovedVendorRequest(ApprovedVendorRequestDataTable $dataTable){
        return $dataTable->render('admin.vendor-request.status.approved');
    }


    public function changeStatus(Request $request ,String $id)
    {


        // dd($request->all());
        $vendor = Vendor::find($id);

        if($vendor->status == 1){
            return response(['status'=>'error','message'=>'This Vendor You Can\"t Change Their Status Because You Approve it last time','warning','Warning!']);
            
        }

        //force delete vendor : 

        // if($vendor->status == 1){ // you need to add a dropdown for status(approve/pending/decline)
        //     return response(['status'=>'error','message'=>'This Vendor You Can\"t Change Their Status Because You Approve it last time','warning','Warning!']);
        // }


        if(!$vendor){
            return response(['status'=>'error','message'=>'Vendor is not found!']);
        }

        $vendor->update([
            'status' => $request->status
        ]);


        if($request->status == 1){
            User::where('id',$vendor->user_id)->update([
                'role'=>'vendor'
            ]);
        }



        toastr('Vendor Status Changed!','success','Success');
        return redirect()->route('admin.vendor-request.index');
    }
}
