<?php

namespace App\Http\Controllers\Frontend\User;

use App\DataTables\UserOrdersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;


class UserOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserOrdersDataTable $dataTable)
    {
        return $dataTable->render('frontend.user.dashboard.order.index');
        
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data['order'] = Order::with([
            'transaction',
            'orderProducts'
        ])->find($id);



        if(!$data['order']){
            toastr('Order Not Found','error','Error!');
            return redirect()->route('user.order.index');
        }

       $data['order_address'] = json_decode($data['order']->order_address);
       $data['shipping_method'] = json_decode($data['order']->shipping_method);
       $data['coupon'] = json_decode($data['order']->coupon);
       
        return view('frontend.user.dashboard.order.order-details',$data);
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
            return to_route('user.order.index');
        }

        $order_id = $order->invoice_id;

        $order->delete();
        
        return response(['status'=>'success','message'=>"The Order Number $order_id has been sent to the trash !"]);
        
    }

    public function trashed_orders(){
        $trashed_orders = Order::onlyTrashed()->get();

        // dd($trashed_orders);
        return view('frontend.user.dashboard.order.order_trash',compact('trashed_orders'));
    }

    public function trashed_orders_restore(string $id){
       
        $restore = Order::withTrashed()->find($id)->restore();
        toastr()->success( 'Order Has Been Resotred Successfully !');
        return to_route('user.order.trashed-orders');
    }

    public function trashed_orders_delete(string $id){

        $delete = Order::withTrashed()->find($id)->forceDelete();

        toastr()->success( 'Order Has Been Deleted Successfully !');
        return to_route('user.order.trashed-orders');
    }}
