@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Footer Information "}}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Footer Information </h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item">Footer Information</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                
                <div class="card">
                    <div class="card-header">
                     <h4>Footer information </h4>
    
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.footer-info.update')}}" method="post" enctype="multipart/form-data">

                            @csrf

                            @if (@$footerInfo['logo'] != null)
                                
                                <img src="{{@$footerInfo['logo']}}" width="200px" alt="footer-logo">  

                            @endif
                            
                            <br><br>

                            <div class="form-group">
                                <input type="file" name="logo" class="form-control" >
                            </div>




                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Phone</label>
                                        {{-- <input type="tel" name="" id=""> --}}
                                        <input type="phone" name="phone" class="form-control"  placeholder="Phone Number" value="{{@$footerInfo['phone']}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Email</label>
                                        <input type="email" name="email" class="form-control"  placeholder="Email" value="{{@$footerInfo['email']}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="type">Address</label>
                                        <input type="text" name="address" class="form-control"  placeholder="Address" value="{{@$footerInfo['address']}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Copyright</label>
                                        <input type="text" name="copyright" class="form-control"  placeholder="Copyright" value="{{@$footerInfo['copyright']}}">
                                    </div>
                                </div>
                            </div>

      
                            <input type="submit" class="btn btn-primary" name="submit" value="Update">




                        </form>
                    
                    </div>
                </div>

        </div>

        </div>
    </section>
@endsection