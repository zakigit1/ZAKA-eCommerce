<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\DataTables\VendorOrdersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VendorOrdersDataTable $dataTable)
    {
        return $dataTable->render('vendor.order.index');
    }


    /**
        * Order Status 
    */

    // public function pendingOrders(VendorPendingOrderDataTable $dataTable){
        
    //     return $dataTable->render('vendor.order.order-status.pending');
    // }

    // public function processedOrders(VendorProcessedOrderDataTable $dataTable){
        
    //     return $dataTable->render('vendor.order.order-status.processing');
    // }

   

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['order'] = Order::with([
            'transaction',
            'orderProducts'=>function($q){
            return $q->where('vendor_id',Auth::user()->vendor->id);
        }])->find($id);


        if(!$data['order']){
            toastr('Order Not Found','error','Error!');
            return redirect()->route('admin.order.index');
        }

       $data['order_address'] = json_decode($data['order']->order_address);
       $data['shipping_method'] = json_decode($data['order']->shipping_method);
       $data['coupon'] = json_decode($data['order']->coupon);
       
        return view('vendor.order.order-details',$data);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $order = Order::find($id);
        

        if(!$order){
            toastr()->error( 'Order is not found!');
            return to_route('vendor.order.index');
        }

        $order_id = $order->invoice_id;

        $order->delete();
        
        return response(['status'=>'success','message'=>"The Order Number $order_id has been sent to the trash !"]);
        
    }

    public function trashed_orders(){
        $trashed_orders = Order::onlyTrashed()->get();

        // dd($trashed_orders);
        return view('vendor.order.order_trash',compact('trashed_orders'));
    }

    public function trashed_orders_restore(string $id){
       
        $restore = Order::withTrashed()->find($id)->restore();
        toastr()->success( 'Order Has Been Resotred Successfully !');
        return to_route('vendor.order.trashed-orders');
    }

    public function trashed_orders_delete(string $id){


        /** 
            * ! this two line i dont need it because i am using a forgein key in my tables if
            i delete the order the orderProducts and transaction will deleted automatique 

            if i dont use a forgein key i need to delete the orderproducts + transaction
        */

        // // first we delete the orderProducts : 
        // $order->orderProducts()->delete();

        // // secendly we delete the transaction : 
        // $order->transaction()->delete();

        //finally we delete the order : 

        $delete = Order::withTrashed()->find($id)->forceDelete();

        toastr()->success( 'Order Has Been Deleted Successfully !');
        return to_route('vendor.order.trashed-orders');
    }


    public function change_order_status(Request $request)
    {

        $order = Order::find($request->id);

        if(!$order){
            toastr()->error( 'order is not found!');
            return to_route('vendor.order.index');
        }

       
        $order->order_status = $request->status;
         
        $order->save();

        
        return response([
            'status'=>'success',
            'message'=>"Update Order Status Successfully!"
        ]);

       
    }




    public function change_payment_status(Request $request)
    {
        // dd($request->all());
        $order = Order::find($request->id);

        if(!$order){
            toastr()->error( 'order is not found!');
            return to_route('vendor.order.index');
        }

       
        $order->payment_status = $request->status ;
         
        $order->save();

        $status =($order->payment_status == 1) ? 'Complete' : 'Pending';

        return response(['status'=>'success','message'=>"Payment Status Has Been Updated Successfully!"]);

       
    }
}
