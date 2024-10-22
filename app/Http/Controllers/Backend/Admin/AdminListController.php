<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\AdminListDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminListController extends Controller
{
    public function index(AdminListDataTable $dataTable){
        return $dataTable->render('admin.admin-list.index');
        
    }



    

    public function change_status(Request $request)
    {

        $admin = User::find($request->id);

        if(!$admin){
            return response(['status'=>'error','message'=>'Admin is not found!']);
        }

       
        $admin->status = $request->status == 'true' ? 'active' : 'inactive';
         
        $admin->save();

    
        return response(['status'=>'success','message'=>"The User has been $admin->status"]);

       
    }

    public function destroy(string $id){
      
        try{

            $admin = User::find($id);

            
            if(!$admin){
                return response(['status'=>'error','message'=>'admin is not found!']);
            }

            // if this admin has products :(  ***************** If admin he don't have vendor this is a problem create for it a vendor or remove it )
            $products = Product::where('vendor_id',$admin->vendor->id)->get();
    
            if(count($products) > 0){
                return response(['status'=>'error','message'=>"You Can't Delete This Admin . Please Ban It Instead To Deleted!"]);
            }
    

            // if the admin is a vendor also (this condition you can remove it later because first i create admins withou vendors that way i check )
            // $adminVendor = Vendor::where('user_id',$admin->id)->first();
            
            // if($adminVendor){
                //     $adminVendor->delete();
            // }
            
            Vendor::where('user_id',$admin->id)->delete();
            $admin->delete();
    
            return response(['status'=>'success','message'=>"Admin Has Been Deleted Successfully !"]);
        }catch(\Exception $ex){
            
            return response(['status'=>'error','message'=>$ex->getMessage()]);
        }

    }
}
