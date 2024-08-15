@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Admin Profile "}}
@endsection

@section('content')
    <section class="section">

        <div class="section-header">
            <h1>Admin Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{route('admin.dashboard')}}">
                        Dashboard
                    </a>
                </div>

                <div class="breadcrumb-item">
                   Admin Profile
                </div>
            </div>
        </div>

        <div class="section-body">

            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <form method="post" action="{{route('admin.profile.update')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        
                        @csrf

                        <div class="card-header">
                            <h4>Edit Admin Profile</h4>
                        </div>

                        <div class="card-body">
                            <div class="row ">

                                <div class="form-group " >
                                    {{-- <img height="200"  width="250"  src="{{ (auth()->user()->image) ? auth()->user()->image : asset('frontend/assets/images/ts-2.jpg')}}" alt="profile_image"> --}}

                                    @if(auth()->user()->image && file_exists(public_path(auth()->user()->image)))
                                            <img height="200"  width="250" src="{{ auth()->user()->image }}" alt="profile_image" class="img-fluid">
                                    @else
                                            <img src="{{ asset('frontend/assets/images/ts-2.jpg') }}" alt="default-image" class="img-fluid">
                                    @endif
                                </div>

                                <div class="form-group  col-12">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" value="">
                                </div>
                            </div>

                            <div class="row">
            
                                <div class="form-group col-md-5 col-12">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{auth()->user()->name}}">

                                    @if ($errors->has('name'))
                                        <?php // toastr()->error($errors->first('name')) ?>
                                        <code>{{$errors->first('name')}}</code>                        
                                        @endif
                                </div>
                                    
                                <div class="form-group col-md-7 col-12">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{auth()->user()->email}}" >
                                        
                                    @if ($errors->has('email'))
                                        <?php // toastr()->error($errors->first('email')) ?>
                                        <code>{{$errors->first('email')}}</code>                        
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="card-footer text-right">
                        <button class="btn btn-primary">Save Changes</button>
                        </div>

                    </form>
                </div>
            </div>
            
        </div>

        <div class="section-body">

            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    
                    <form method="post" action="{{route('admin.profile.update.password')}}"  class="needs-validation" novalidate="" >
                      
                      @csrf
                        <div class="card-header">
                            <h4>Edit Password</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="form-group  col-12">
                                    <label>Current Password</label>

                                    <input type="password" name="current_password" class="form-control" >
                                    
                                    @if ($errors->has('current_password'))
                                        <?php // toastr()->error($errors->first('current_password')) ?>
                                        <code>{{$errors->first('current_password')}}</code>                        
                                    @endif

                                </div>

                                <div class="form-group col-12">

                                    <label>New Password</label>

                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control"  autocomplete="new-password">
                                        
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility(this)">Show</button>
                                        </div>
                                    </div>
                                    
                                    @if ($errors->has('password'))
                                        <?php // toastr()->error($errors->first('password')) ?>
                                        <code>{{$errors->first('password')}}</code>                        

                                    @endif



                                </div>
                                
                                <div class="form-group  col-12">

                                    <label>Password Confirmation</label>

                                    <input type="password" name="password_confirmation" class="form-control"   autocomplete="new-password">
                                        
                                    @if ($errors->has('password_confirmation'))
                                        <?php // toastr()->error($errors->first('password_confirmation')) ?>
                                        <code>{{$errors->first('password_confirmation')}}</code>                        
                                       
                                    @endif

                                </div>
                                
                            </div>

                        </div>

                        <div class="card-footer text-right">
                        <button class="btn btn-primary">Save Changes</button>
                        </div>

                    </form>
                </div>
            </div>
            
        </div>

    </section>
@endsection


<script>
    function togglePasswordVisibility(element) {
        var passwordInput = element.previousElementSibling;
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            element.innerText = "Hide";
        } else {
            passwordInput.type = "password";
            element.innerText = "Show";
        }
    }
</script>
