@extends('Frontend.user.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || User Order Trashed "}}
@endsection



@section('content')


    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i>All Orders Deleted</h3>
                

                <div class="back_button">
                    <a href="{{route('user.order.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                </div>
                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        <table class="table table-striped table-bordered border-dark">
                            <thead style="background: #f2f2f2">
                            <tr>
                                <th scope="col">invoice_id</th>
                                <th scope="col">date</th>
                                <th scope="col">deleted_at</th>
                                <th scope="col">product_qty</th>
                                <th scope="col">amount</th>
                                <th scope="col">order_status</th>
                                <th scope="col">payment_status</th>
                                <th scope="col">payment_method</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($trashed_orders) && count($trashed_orders))
                                    @foreach ($trashed_orders as $trashed_order)          
                                        <tr>
                                            <td>{{$trashed_order->invoice_id}}</td>
                                            <td>{{date('Y-m-d',strtotime($trashed_order->created_at))}}</td>
                                            <td>{{date('Y-m-d',strtotime($trashed_order->deleted_at))}}</td>
                                            <td>{{$trashed_order->product_qty}}</td>
                                            <td>{{$settings->currency_icon}}{{$trashed_order->amount}} </td>
                                            <td> 

                                                @switch($trashed_order->order_status)
                                                    @case('pending')
                                                        <i class="badge bg-warning">Pending</i>
                                                        @break
                                                    @case('processed_and_ready_to_ship')
                                                        <i class="badge bg-info">Processing</i>
                                                        @break
                                                    @case('dropped_off')
                                                        <i class="badge bg-info">Dropped Off</i>
                                                        @break
                                                    @case('shipped')
                                                        <i class="badge bg-info">Shipped</i>
                                                        @break
                                                    @case('out_for_delivery')
                                                        <i class="badge bg-light">Out For Delivery</i>
                                                        @break
                                                    @case('delivered')
                                                        <i class="badge bg-success">Delivered</i>
                                                        @break
                                                    @case('canceled')
                                                        <i class="badge bg-danger">Canceled</i>
                                                        @break
                                                
                                                    @default
                                                        <i class="badge bg-dark">None</i>
                                                @endswitch



                                                
                                            </td>

                                            
                                            <td>
                                                @if($trashed_order->payment_status == 1)
                                                    <i class="badge bg-success">Complete</i>
                                                @else
                                                    <i class="badge bg-danger">Pending</i>
                                                @endif

                                            </td>
                                            
                                            <td>{{$trashed_order->payment_method}}</td>

                                            <td>  
                                                <div class="d-flex">
                                                    <a class="btn-sm btn-primary btn mx-2" href="{{route('user.order.trashed-orders.restore', $trashed_order->id)}}">Restore <i class="fas fa-undo"></i></a>
                                                    <a class="btn-sm btn-danger btn mx-2" href="{{route('user.order.trashed-orders.delete', $trashed_order->id)}}">Delete <i class='fas fa-trash-alt'></i></a>
                                                </div>
                        
                                            </td>
                        
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">No orders in the trash</td>
                                    </tr>
                                @endif
                            
                            </tbody>
            
                        </table>
                            
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection





