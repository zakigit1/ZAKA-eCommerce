@extends('Frontend.user.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || User Dashboard "}}
@endsection


@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <div class="wsus__dashboard">
                    {{-- <h3><i class="far fa-user"></i> Manage User Dashboard</h3> --}}
                    <h3><i class='fas fa-id-card' style='font-size:36px;color:black;'></i>User Dashboard</h3>
                    <hr><br>
                    <div class="row">
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item red" href="{{route('user.order.index')}}">
                                <i class="far fa-address-book"></i>
                                <p>Total Order</p>
                                <h4 style="color: white">{{ $totalOrders }}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item green" href="{{route('user.order.index')}}">
                                <i class="fas fa-sync"></i>
                                <p>Pending Order</p>
                                <h4 style="color: white">{{$pendingOrders}}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item sky" href="{{route('user.order.index')}}">
                                <i class="fas fa-handshake"></i>
                                <p>Complete Order</p>
                                <h4 style="color: white">{{$completeOrders}}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item blue" href="{{route('user.product-review.index')}}">
                                <i class="fas fa-star"></i>
                                <p>Reviews</p>
                                <h4 style="color: white">{{$reviews}}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item orange" href="{{route('user.wishlist.index')}}">
                                <i class="far fa-heart"></i>
                                <p>Wishlist</p>
                                <h4 style="color: white">{{$wishlists}}</h4>
                            </a>
                        </div>
                        <div class="col-xl-2 col-6 col-md-4">
                            <a class="wsus__dashboard_item purple" href="{{route('user.profile.index')}}">
                                <i class="fas fa-user-shield"></i>
                                <p>Profile</p>
                                <h4 style="color: white">-</h4>
                            </a>
                        </div>
                    </div>

            </div>
        </div>
        </div>
    </div>

@endsection