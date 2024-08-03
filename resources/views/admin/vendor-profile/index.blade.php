@extends('Admin.Dashboard.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Admin Vendor Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            {{-- <div class="breadcrumb-item"><a href="{{route('admin.slider.index')}}">Sliders</a></div> --}}
            <div class="breadcrumb-item">Update</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                
                <div class="card">
                    <div class="card-header">
                        <h4>Update Admin Vendor Profile</h4>

                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.vendor-profile.update')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label >Preview </label><br>
                                <img  width="200px" src="{{$profile->banner}}" alt="admin-vendor-img">
                            </div>
                            <div class="form-group">
                                <label >Banner</label>
                                <input type="file" name="banner" class="form-control"  >
                            </div>

                            <div class="form-group wsus__input">
                                <label>Shop Name</label>
                               
                                <input type="text" name="shop_name" class="form-control" id="" placeholder="Shop Name" value="{{$profile->shop_name}}">
                            </div>
                            
                            <div class="form-group">
                                <label>Phone</label>
                                {{-- <input type="tel" name="" id=""> --}}
                                <input type="phone" name="phone" class="form-control" id="" placeholder="Phone" value="{{$profile->phone}}">
                            </div>
                            <div class="form-group">
                                <label >Email</label>
                                <input type="email" name="email" class="form-control" id="" placeholder="Email" value="{{$profile->email}}">
                            </div>
                            <div class="form-group">
                                <label >Address</label>
                                <input type="text" name="address" class="form-control" id="" placeholder="Address" value="{{$profile->address}}">
                                {{-- name="address" --}}
                            </div>
                            <div class="form-group">
                                <label >Description</label>
                                {{-- <input type="text" name="description" class="form-control"  placeholder="Bio" value=""> --}}
                                <textarea class="summernote" style="display: none;" name="description" value="">{{$profile->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label >Facebook </label>
                                <input type="text" name="fb_link" class="form-control" placeholder="Facebook Link" value="{{$profile->fb_link}}">
                            </div>
                            <div class="form-group">
                                <label >Twitter </label>
                                <input type="text" name="tw_link" class="form-control"  placeholder="Twitter Link" value="{{$profile->tw_link}}">
                            </div>
                            <div class="form-group">
                                <label >Instgrame </label>
                                <input type="text" name="insta_link" class="form-control"  placeholder="Instagram Link" value="{{$profile->insta_link}}">
                            </div>
   
                            

                            <input type="submit" class="btn btn-primary" name="submit" value="Update">




                        </form>
                    
                    </div>
                </div>

        </div>

        </div>
    </section>
@endsection