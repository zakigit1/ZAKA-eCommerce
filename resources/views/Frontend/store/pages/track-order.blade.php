@extends('Frontend.store.layouts.master')

@section('title', "$settings->site_name || Order Tracking ")

@section('content')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Order Tracking</h4>
                        <ul>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><a href="javascript:;">Order Tracking</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        TRACKING ORDER START
    ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="wsus__track_area">
                <div class="row">
                    <div class="col-xl-5 col-md-10 col-lg-8 m-auto">
                        <form class="tack_form" action="{{route('user.track-order.index')}}" method="GET">
                            @csrf

                            <h4 class="text-center">order tracking</h4>

                            <p class="text-center">tracking your order status</p>

                            <div class="wsus__track_input">
                                <label class="d-block mb-2">order id*</label>
                                <input type="text" name="order_id" placeholder="#21578455" value="{{(isset($order)? '#': '').@$order->invoice_id}}">
                            </div>

                            <button type="submit" class="common_btn">track</button>
                            
                        </form>
                    </div>
                </div>

                @if(isset($order))

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="wsus__track_header">
                                <div class="wsus__track_header_text">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 col-lg-3">
                                            <div class="wsus__track_header_single">
                                                <h5>Order Date :</h5>
                                                <p>{{date('d M Y',strtotime(@$order->created_at))}}</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-lg-3">
                                            <div class="wsus__track_header_single">
                                                <h5>shopping by:</h5>
                                                <p>{{@$order->user->name}}</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-lg-3">
                                            <div class="wsus__track_header_single">
                                                <h5>status:</h5>
                                                <p>{{@$order->order_status}}</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-lg-3">
                                            <div class="wsus__track_header_single border_none">
                                                <h5>tracking:</h5>
                                                <p>#{{@$order->invoice_id}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-12">
                            <ul class="progtrckr" data-progtrckr-steps="4">

                                <li class="progtrckr_done icon_one check_mark">Order Pending</li>

                                @if (@$order->order_status == 'canceled')
                                    <li class="icon_four red_mark"> Order Canceled </li>
                                @else
                                    
                                    <li class="progtrckr_done icon_two 
                                        @if (@$order->order_status == 'processed_and_ready_to_ship' ||
                                            @$order->order_status == 'dropped_off' ||
                                            @$order->order_status == 'shipped' ||
                                            @$order->order_status == 'out_for_delivery' ||
                                            @$order->order_status == 'delivered')

                                            check_mark
                                        @endif"> 
                                        Order Processing
                                    </li>

                                

                                    <li class="progtrckr_done icon_three 
                                        @if (@$order->order_status == 'out_for_delivery' ||
                                            @$order->order_status == 'delivered')

                                            check_mark
                                        @endif"> 
                                        On The Way
                                    </li>

                                
                                    <li class="progtrckr_done icon_four 
                                        @if (@$order->order_status == 'delivered')
                                            check_mark
                                        @endif"> 
                                        Delivered
                                    </li>

                                @endif

                            </ul>
                        </div>
                        
                        <div class="col-xl-12">
                            <a href="{{route('home')}}" class="common_btn"><i class="fas fa-chevron-left"></i> back to home</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!--============================
        TRACKING ORDER END
    ==============================-->

    
@endsection