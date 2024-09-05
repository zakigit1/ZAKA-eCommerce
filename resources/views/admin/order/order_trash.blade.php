@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Admin Order Trashed "}}
@endsection



@section('content')


    <section class="section">
        <div class="section-header">
            <h1>Manage Orders</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{route('admin.order.index')}}">Orders</a></div>
                <div class="breadcrumb-item">Trashed Orders</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                {{-- <div class="container"> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>All Orders Deleted </h4>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-bordered border-dark">
                                <thead style="background: #f2f2f2">
                                  <tr>
                                    <th scope="col">invoice_id</th>
                                    <th scope="col" style="width: 40%">date</th>
                                    <th scope="col" style="width: 40%">deleted_at</th>
                                    <th scope="col" style="width: 10%">product_qty</th>
                                    <th scope="col" style="width: 20%">amount</th>
                                    <th scope="col" style="width: 10%">order_status</th>
                                    <th scope="col" style="width: 10%">payment_status</th>
                                    <th scope="col" style="width: 10%">payment_method</th>
                                    <th scope="col" style="width: 20%">Action</th>
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
                                                <td>{{$settings->currency_icon}} {{$trashed_order->amount}} </td>
                                                <td> 
                                                    @if($trashed_order->order_status == 'pending') 
                                                    <i class="badge badge-warning">pending</i>
                                                    @endif
                                                    
                                                </td>

                                                
                                                <td>
                                                    @if($trashed_order->payment_status == 1)
                                                        <i class="badge badge-success">Complete</i>
                                                    @else
                                                        <i class="badge badge-danger">Pending</i>
                                                    @endif

                                                </td>
                                                
                                                <td>{{$trashed_order->payment_method}}</td>

                                                <td>  
                                                    <div class="d-flex">
                                                        <a class="btn-sm btn-primary btn mx-2" href="{{route('admin.order.trashed-orders.restore', $trashed_order->id)}}">Restore</a>
                                                        <a class="btn-sm btn-danger btn mx-2" href="{{route('admin.order.trashed-orders.delete', $trashed_order->id)}}">Delete</a>
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
    </section>
@endsection

