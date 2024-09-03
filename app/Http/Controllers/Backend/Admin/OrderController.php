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
            return redirect()->route('admin.orders.index');
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
        //
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
