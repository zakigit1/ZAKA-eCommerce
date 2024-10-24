@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Vendor Shop profile "}}
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i> Update Vendor Profile</h3>
                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">
                        {{-- <h4>User information</h4> --}}
                        
                        <div class="row">
                            <h4>Basic information</h4>
                            {{-- <div class="section-body"> --}}

                            <form action="{{route('vendor.shop-profile.update',$profile->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
    
                                <div class="form-group wsus__input">
                                    <label >Preview </label><br>
                                    <img  width="100px" height="100px" src="{{$profile->banner}}" alt="admin-vendor-img">
                                </div>
                                <div class="form-group wsus__input">
                                    <label >Banner</label>
                                    <input type="file" name="banner" class="form-control"  >
                                </div>

                                <div class="form-group wsus__input">
                                    <label>Shop Name</label>
                                    <input type="text" name="shop_name" class="form-control" id="" placeholder="Shop Name" value="{{$profile->shop_name}}">
                                </div>
                                <div class="form-group wsus__input">
                                    <label>Phone</label>
                                    {{-- <input type="tel" name="" id=""> --}}
                                    <input type="phone" name="phone" class="form-control" id="" placeholder="Phone" value="{{$profile->phone}}">
                                </div>
                                <div class="form-group wsus__input">
                                    <label >Email</label>
                                    <input type="email" name="email" class="form-control" id="" placeholder="Email" value="{{$profile->email}}">
                                </div>
                                <div class="form-group wsus__input">
                                    <label >Address</label>
                                    <input type="text" name="address" class="form-control" id="" placeholder="Address" value="{{$profile->address}}">
                                    {{-- name="address" --}}
                                </div>
                                <div class="form-group wsus__input">
                                    <label for="">Description</label> <br>
                                    <textarea name="description" class="form-control summernote" >
                                        {{$profile->description}}
                                    </textarea>
                                </div>
                                <div class="form-group wsus__input">
                                    <label >Facebook </label>
                                    <input type="text" name="fb_link" class="form-control" placeholder="Facebook Link" value="{{$profile->fb_link}}">
                                </div>
                                <div class="form-group wsus__input">
                                    <label >Twitter </label>
                                    <input type="text" name="tw_link" class="form-control"  placeholder="Twitter Link" value="{{$profile->tw_link}}">
                                </div>
                                <div class="form-group wsus__input">
                                    <label >Instgrame </label>
                                    <input type="text" name="insta_link" class="form-control"  placeholder="Instagram Link" value="{{$profile->insta_link}}">
                                </div>
        
                                
    
                                <input type="submit" class="btn btn-primary wsus__input" name="submit" value="Update">
    
    
    
    
                            </form>
                                            
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection