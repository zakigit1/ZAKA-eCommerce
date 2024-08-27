<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\OrdersDataTable;
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
