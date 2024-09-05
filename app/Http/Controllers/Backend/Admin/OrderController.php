<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\UserAddress;
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



    public function show(string $id)
    {
        $data['order'] = Order::with('transaction')->find($id);

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd('edit page');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $order = Order::find($id);
        $order_id = $order->invoice_id;

        if(!$order){
            toastr()->error( 'Order is not found!');
            return to_route('admin.order.index');
        }
        
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
        $delete = Order::withTrashed()->find($id)->forceDelete();

        toastr()->success( 'Order Has Been Deleted Successfully !');
        return to_route('admin.order.trashed-orders');
    }















    // public function change_status(Request $request)
    // {

    //     $order = Order::find($request->id);

    //     if(!$order){
    //         toastr()->error( 'order is not found!');
    //         return to_route('admin.order.index');
    //     }

       
    //     $order->order_status = $request->status == 'true' ? 1 : 0;
         
    //     $order->save();

    //     $status =($order->order_status == 1) ? 'activated' : 'deactivated';

    //     return response(['status'=>'success','message'=>"The Order has been $status"]);

       
    // }
}
