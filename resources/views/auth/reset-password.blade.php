@extends('Frontend.layouts.master')
@section('content')
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>change password</h4>
                        <ul>
                            <li><a href="#">login</a></li>
                            <li><a href="#">change password</a></li>
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
        CHANGE PASSWORD START
    ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-md-10 col-lg-7 m-auto">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <div class="wsus__change_password">
                            <h4>Rest Password </h4>
                            
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="wsus__single_pass">
                                <label>Email</label>
                                <input type="email" id="email"name="email" value="{{old('email', $request->email)}}" placeholder="Email" autofocus>
                            </div>



                            <div class="wsus__single_pass">
                                <label>new password</label>
                                <input type="password" id="password" name="password" placeholder="New Password" autocomplete="new-password">
                            </div>
                            <div class="wsus__single_pass">
                                <label>confirm password</label>
                                <input type="password"   type="password" id="password_confirmation"
                                name="password_confirmation"  autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                            <button class="common_btn" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        CHANGE PASSWORD END
    ==============================-->
@endsection
