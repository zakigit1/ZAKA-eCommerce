@extends('Frontend.store.layouts.master')

@section('title')
    {{ @$settings->site_name . ' ||  Sign in / Register ' }}
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
                        <h4>Sign in / Register</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:;">Sign in / Register</a></li>
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
                   LOGIN/REGISTER PAGE START
                ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 m-auto">
                    <div class="wsus__login_reg_area">
                        <ul class="nav nav-pills mb-3" id="pills-tab2" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link list-view  {{ session()->has('auth_view_list') && session()->get('auth_view_list') == 'login-view' ? 'active' : '' }} 
                                    {{ !session()->has('auth_view_list') ? 'active' : '' }} "
                                    data-id="login-view" id="pills-profile-tab2" data-bs-toggle="pill"
                                    data-bs-target="#pills-profiles" type="button" role="tab"
                                    aria-controls="pills-profiles" aria-selected="true">Sing in</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link list-view {{ session()->has('auth_view_list') && session()->get('auth_view_list') == 'register-view' ? 'active' : '' }} "
                                    data-id="register-view" id="pills-home-tab2" data-bs-toggle="pill"
                                    data-bs-target="#pills-homes" type="button" role="tab" aria-controls="pills-homes"
                                    aria-selected="true">Register</button>
                            </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent2">

                            <!--Login -->
                            <div class="tab-pane fade {{ session()->has('auth_view_list') && session()->get('auth_view_list') == 'login-view' ? 'show active' : '' }} 
                                {{ !session()->has('auth_view_list') ? 'show active' : '' }}"
                                id="pills-profiles" role="tabpanel" aria-labelledby="pills-profile-tab2">

                                <div class="wsus__login">

                                    <form method="POST" action="{{ route('login') }}">

                                        @csrf

                                        <!-- Email Field-->
                                        <div class="wsus__login_input">
                                            <i class="fas fa-user-tie"></i>
                                            <input type="email" name ="email" value="{{ old('email') }}"
                                                placeholder="Email">
                                        </div>


                                        <!-- Password Field-->
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" name ="password" placeholder="Password">
                                        </div>


                                        <div class="wsus__login_save d-flex justify-content-between align-items-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Remember
                                                    me</label>
                                            </div>

                                            @if (Route::has('password.request'))
                                                <a class="forget_p" href="{{ route('password.request') }}">Forget
                                                    Password?</a>
                                            @endif
                                        </div>

                                        <button class="common_btn" type="submit">Login</button>

                                        {{-- <p class="social_text">Sign in with social account</p>
                                                                    <ul class="wsus__login_link">
                                                                        <li><a href="#"><i class="fab fa-google"></i></a></li>
                                                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                                                    </ul> --}}
                                    </form>
                                </div>
                            </div>

                            <!--Register -->

                            <div class="tab-pane fade {{ session()->has('auth_view_list') && session()->get('auth_view_list') == 'register-view' ? 'show active' : '' }} "
                                id="pills-homes" role="tabpanel" aria-labelledby="pills-home-tab2">

                                <div class="wsus__login">

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <!-- Name Field-->
                                        <div class="wsus__login_input">
                                            <i class="fas fa-user-tie"></i>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                placeholder="Name" autofocus autocomplete="name">
                                        </div>

                                        <div class="wsus__login_input">
                                            <i class="far fa-envelope"></i>
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                placeholder="Email">
                                        </div>

                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" name="password" placeholder="Password"
                                                autocomplete="new-password">
                                        </div>
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" name="password_confirmation"
                                                placeholder="Confirm Password" autocomplete="new-password">
                                        </div>
                                        <div class="text-end">
                                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-3"
                                                href="{{ route('login') }}">
                                                Already registered?
                                            </a>
                                        </div>


                                        <button class="common_btn mt-4" type="submit">Sign up</button>
                                    </form>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                   LOGIN/REGISTER PAGE END
                ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.list-view').on('click', function() {


                let style = $(this).data('id');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('auth-view-list') }}',
                    data: {
                        style: style,
                    },
                    success: function(data) {

                    }
                });
            });

        });
    </script>
@endpush
