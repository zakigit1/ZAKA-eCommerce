@extends('Frontend.user.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || User Profile "}}
@endsection



@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i> profile</h3>
                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">
                        {{-- <h4>User information</h4> --}}
                        
                        <div class="row">
                            <h4>Basic information</h4>
                            <form action="{{route('user.profile.update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                        <div class="col-sm-6 col-md-2">
                                            <div class="wsus__dash_pro_img">
                                                
                                            @if(auth()->user()->image && file_exists(public_path(auth()->user()->image)))
                                                <img src="{{ auth()->user()->image }}" alt="user-image" class="img-fluid">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/ts-2.jpg') }}" alt="default-image" class="img-fluid">
                                            @endif
                                                 
                                                <input type="file" name="image" >
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-md-5 ">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-user-tie"></i>
                                                    <input type="text" placeholder=" Name" name="name" value="{{auth()->user()->name}}">
                                                </div>
                                            </div>

                                            <div class="col-md-7">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fal fa-envelope-open"></i>
                                                    <input type="email" placeholder="Email" name="email" value="{{auth()->user()->email}}">
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="col-xl-12">
                                    <button class="common_btn mb-4 mt-2" name="submit" type="submit">Save Changes</button>
                                </div>
                            </form>
                            <h4>Update Password</h4>
                            <form action="{{route('user.profile.update.password')}}" method="POST">
                               @csrf
                                <div class="wsus__dash_pass_change mt-2">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-unlock-alt"></i>
                                                <input type="password" placeholder="Current Password" name="current_password">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-lock-alt"></i>
                                                <input type="password" name="password" placeholder="New Password" autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-lock-alt"></i>
                                                <input type="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
                                               

                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <button class="common_btn" name="submit" type="submit">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection