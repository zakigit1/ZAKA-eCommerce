@extends('Frontend.store.layouts.master')

@section('title', @$settings->site_name ." Payment")

@section('content')

    <!--============================
            BREADCRUMB START
        ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Payment</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:;">Payment</a></li>
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
            PAYMENT PAGE START
        ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="wsus__payment_menu" id="sticky_sidebar">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">

                                <button class="nav-link common_btn active" id="v-pills-paypal-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-paypal" type="button" role="tab"
                                    aria-controls="v-pills-paypal" aria-selected="true">Paypal </button>

                                <button class="nav-link common_btn" id="v-pills-stripe-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-stripe" type="button" role="tab"
                                    aria-controls="v-pills-stripe" aria-selected="false">Stripe </button>

                                <button class="nav-link common_btn" id="v-pills-razorpay-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-razorpay" type="button" role="tab"
                                    aria-controls="v-pills-razorpay" aria-selected="false">Razorpay </button>

                                <button class="nav-link common_btn" id="v-pills-cod-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-cod" type="button" role="tab" aria-controls="v-pills-cod"
                                    aria-selected="false">COD </button>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="tab-content" id="v-pills-tabContent" id="sticky_sidebar">
                            <div class="tab-pane fade show active" id="v-pills-paypal" role="tabpanel"
                                aria-labelledby="v-pills-paypal-tab">

                                {{-- <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <form>
                                                <div class="wsus__pay_caed_header">
                                                    <h5>credit or debit card</h5>
                                                    <img src="{{asset('frontend/assets/images/payment5.png')}}" alt="payment" class="img-=fluid">
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input class="input" type="text"
                                                            placeholder="MD. MAHAMUDUL HASSAN SAZAL">
                                                    </div>
                                                    <div class="col-12">
                                                        <input class="input" type="text"
                                                            placeholder="2540 4587 **** 3215">
                                                    </div>
                                                    <div class="col-4">
                                                        <input class="input" type="text" placeholder="MM/YY">
                                                    </div>
                                                    <div class="col-4 ms-auto">
                                                        <input class="input" type="text" placeholder="1234">
                                                    </div>
                                                </div>
                                                <div class="wsus__save_payment">
                                                    <h6><i class="fas fa-user-lock"></i> 100% secure payment with :</h6>
                                                    <img src="{{asset('frontend/assets/images/payment1.png')}}" alt="payment" class="img-fluid">
                                                    <img src="{{asset('frontend/assets/images/payment2.png')}}" alt="payment" class="img-fluid">
                                                    <img src="{{asset('frontend/assets/images/payment3.png')}}" alt="payment" class="img-fluid">
                                                </div>
                                                <div class="wsus__save_card">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="flexSwitchCheckDefault">
                                                        <label class="form-check-label"
                                                            for="flexSwitchCheckDefault">save thid Card</label>
                                                    </div>
                                                </div>
                                                <button type="submit" class="common_btn">confirm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="wsus__payment_area">
                                    @include('Frontend.store.pages.payment.includes.paypal')
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-stripe" role="tabpanel"
                                aria-labelledby="v-pills-stripe-tab">

                                <div class="wsus__payment_area">
                                    @include('Frontend.store.pages.payment.includes.stripe')
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-razorpay" role="tabpanel"
                                aria-labelledby="v-pills-razorpay-tab">

                                <div class="wsus__payment_area">
                                    @include('Frontend.store.pages.payment.includes.razorpay')
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-cod" role="tabpanel" aria-labelledby="v-pills-cod-tab">

                                <div class="wsus__payment_area">
                                    @include('Frontend.store.pages.payment.includes.cod')
                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="col-xl-4 col-lg-4">
                        <div class="wsus__pay_booking_summary" id="sticky_sidebar2">
                            <h5>Order Summary</h5>
                            <p>subtotal : <span>{{ $settings->currency_icon }}{{ getCartSubtotal() }}</span></p>
                            <p>shipping fee (+) : <span>{{ $settings->currency_icon }}{{ shippingFee() }} </span></p>
                            <p>coupon (-) : <span>{{ $settings->currency_icon }}{{ cartDiscount() }}</span></p>
                            <h6>total :<span>{{ $settings->currency_icon }}{{ finalAmount() }}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
            PAYMENT PAGE END
        ==============================-->

@endsection
