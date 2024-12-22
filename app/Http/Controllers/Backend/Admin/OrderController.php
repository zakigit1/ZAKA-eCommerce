<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\CanceledOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\DroppedOffOrderDataTable;
use App\DataTables\OrdersDataTable;
use App\DataTables\OutForDeliveryOrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\DataTables\ProcessedOrderDataTable;
use App\DataTables\ShippedOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }
    
    
    /**
        * Order Status 
    */

    public function pendingOrders(PendingOrderDataTable $dataTable){
        
        return $dataTable->render('admin.order.order-status.pending');
    }

    public function processedOrders(ProcessedOrderDataTable $dataTable){
        
        return $dataTable->render('admin.order.order-status.processing');
    }

    public function dropped_offOrders(DroppedOffOrderDataTable $dataTable){
        
        return $dataTable->render('admin.order.order-status.dropped-off');
    }

    public function shippedOrders(ShippedOrderDataTable $dataTable){
        
        return $dataTable->render('admin.order.order-status.shipped');
    }

    public function out_for_deliveryOrders(OutForDeliveryOrderDataTable $dataTable){
        
        return $dataTable->render('admin.order.order-status.out-for-delivery');
    }

    public function deliveredOrders(DeliveredOrderDataTable $dataTable){
        
        return $dataTable->render('admin.order.order-status.delivered');
    }

    public function canceledOrders(CanceledOrderDataTable $dataTable){
        
        return $dataTable->render('admin.order.order-status.canceled');
    }





    public function show(string $id)
    {
        $data['order'] = Order::with(['transaction','orderProducts'])->find($id);

        if(!$data['order']){
            toastr('Order Not Found','error','Error!');
            return redirect()->route('admin.order.index');
        }

       $data['order_address'] = json_decode($data['order']->order_address);
       $data['shipping_method'] = json_decode($data['order']->shipping_method);
       $data['coupon'] = json_decode($data['order']->coupon);
       
        return view('admin.order.order-details',$data);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $order = Order::find($id);
        

        if(!$order){
            return response(['status'=>'error','message'=>'Order is not found!']);
        }

        $order_id = $order->invoice_id;

        $order->delete();
        
        return response(['status'=>'success','message'=>"The Order Number $order_id has been sent to the trash !"]);
        
    }

    public function trashed_orders(){
        $trashed_orders = Order::onlyTrashed()->get();

        // dd($trashed_orders);
        return view('admin.order.order_trash',compact('trashed_orders'));
    }

    public function trashed_orders_restore(string $id){
       
        $restore = Order::withTrashed()->find($id)->restore();
        toastr()->success( 'Order Has Been Resotred Successfully !');
        return to_route('admin.order.trashed-orders');
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
        return to_route('admin.order.trashed-orders');
    }




    public function change_order_status(Request $request)
    {
        
        $order = Order::find($request->id);

        if(!$order){
            return response(['status'=>'error','message'=>'Order is not found!']);
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
            return to_route('admin.order.index');
        }

       
        $order->payment_status = $request->status ;
         
        $order->save();

        $status =($order->payment_status == 1) ? 'Complete' : 'Pending';

        return response(['status'=>'success','message'=>"Payment Status Has Been Updated Successfully!"]);

       
    }
}
