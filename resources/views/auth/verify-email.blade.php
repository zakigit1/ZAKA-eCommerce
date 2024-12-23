

@extends('Frontend.store.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Email Verification "}}
@endsection

@section('content')
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>email verfication</h4>
                        <ul>
                            <li><a href="{{route('home')}}">Store</a></li>
                            <li><a href="javascript:;">Email Verfication</a></li>
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
        Email Verification START
    ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 m-auto">
                    <div class="wsus__forget_area">

                        
                        <div class="mb-4 text-sm text-gray-600 font-semibold italic">
                            <span style="font-weight: 500">
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </span>
                        </div>
                    
                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-success">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="mt-5 d-flex justify-content-between">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                        
                                    <button type ='submit'  class ='text-light btn btn-primary'>
                                        {{ __('Resend Verification Email') }}
                                    </button>

                                </form>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                        
                                    <button type="submit" class="see_btn">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        Email Verification END
    ==============================-->
@endsection

















