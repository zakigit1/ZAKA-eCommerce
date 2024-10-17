@extends('vendor.Dashboard.layouts.master')


@section('title')
    {{"$settings->site_name || Vendor Dashboard "}}
@endsection




@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <div class="wsus__dashboard">
                    <h3><i class='fas fa-id-card' style='font-size:36px;color:black;'></i> Vendor Dashboard</h3>
                    <hr><br>
                    <div class="row">
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item red" href="{{route('vendor.order.index')}}">
                                <i class="far fa-address-book"></i>
                                <p>Today's Order</p>
                                
                                <h4 style="color: white">{{ $todaysOrders }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item orange" href="{{route('vendor.order.index')}}">
                                <i class="fal fa-cloud-download"></i>
                                <p>Order Pending TD </p> {{--TD's = Today's--}}
                                <h4 style="color: white">{{ $todaysPendingOrders }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item sky" href="{{route('vendor.order.index')}}">
                                <i class="fas fa-star"></i>
                                <p>Total Order</p>
                                <h4 style="color: white">{{ $totalOrders }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item blue" href="{{route('vendor.order.index')}}">
                                <i class="far fa-heart"></i>
                                <p>Pending Order</p>
                                <h4 style="color: white">{{ $totalPendingOrders }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item orange" href="{{route('vendor.order.index')}}">
                                <i class="fas fa-user-shield"></i>
                                <p>Complete Order</p>
                                <h4 style="color: white">{{ $totalCompleteOrders }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item purple" href="{{route('vendor.product.index')}}">
                                <i class="fal fa-map-marker-alt"></i>
                                <p>Total Product</p>
                                <h4 style="color: white">{{ $totalProducts }}</h4>
                            </a>
                        </div>

                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item green" href="javascript:;">
                                <i class="far fa-money-bill-wave"></i>
                                <p>Today's Earning</p>
                                <h4 style="color: white">{{$settings->currency_icon}}{{ $todayEarning }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item green" href="javascript:;">
                                <i class="far fa-money-bill-wave"></i>
                                <p>Monthly Earning</p>
                                <h4 style="color: white">{{$settings->currency_icon}}{{ $monthEarning }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item green" href="javascript:;">
                                <i class="far fa-money-bill-wave"></i>
                                <p>Yearly Earning</p>
                                <h4 style="color: white">{{$settings->currency_icon}}{{ $yearEarning }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item green" href="javascript:;">
                                {{-- <i class="fas fa-wallet"></i> --}}
                                <i class="fas fa-sack-dollar"></i>
                                <p>Total Earning</p>
                                <h4 style="color: white">{{$settings->currency_icon}}{{ $totalEarning }}</h4>
                            </a>
                        </div>

                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item purple" href="{{route('vendor.product-review.index')}}">
                                <i class="fal fa-map-marker-alt"></i>
                                <p>Reviews</p>
                                <h4 style="color: white">{{ $totalReview }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item purple" href="{{route('vendor.shop-profile.index')}}">
                                <i class="fal fa-map-marker-alt"></i>
                                <p>Shop Profile</p>
                                <h4 style="color: white">-</h4>
                            </a>
                        </div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>

@endsection