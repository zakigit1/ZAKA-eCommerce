<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\CustomerListDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerListController extends Controller
{
    

    public function index(CustomerListDataTable $dataTable){
        return $dataTable->render('admin.customer-list.index');
        
    }

    
    public function change_status(Request $request)
    {

        $request->validate([
            'id' => 'required|integer|exists:users,id',
            'status' => 'required|in:true,false',
        ]);
        
        $user = User::find($request->id);

        if(!$user){
            return response(['status'=>'error','message'=>'User is not found!']);
        }

       
        $user->status = $request->status == 'true' ? 'active' : 'inactive';
         
        $user->save();

        

        return response(['status'=>'success','message'=>"The User has been $user->status"]);

       
    }
}
