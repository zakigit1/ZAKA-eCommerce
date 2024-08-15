@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Edit Admin Brand "}}
@endsection




@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Edit Brand</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.slider.index')}}">Brands</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <a href="{{route('admin.brand.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a><br>
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Brand</h4>
                        <div class="card-header-action">
                            <a href="{{route('admin.brand.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.brand.update',$brand->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <img height="200"  width="250" src="{{$brand->logo}}" alt="brand-img">

                            <div class="form-group">
                                <label for="image">Logo</label>
                                <input type="file" name="logo" class="form-control" id="logo" placeholder="Logo" >
                            </div>
                            <div class="form-group">
                                <label for="type">Brand Name</label>
                                <input type="text" name="name" class="form-control" id="" placeholder="Brand Name" value="{{$brand->name}}">
                            </div>

                            <div class="form-group ">
                                <label for="inputIsFeatured">Is Featured</label>
                                <select class="form-control" id="inputIsFeatured"  name="is_featured">
                                    
                                    <option {{($brand->is_featured == 1) ? 'selected': ''}} value="1">Yes</option>
                                    <option {{($brand->is_featured == 0) ? 'selected': ''}} value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                    
                                    <option {{($brand->status == 1) ? 'selected':''}} value="1">active</option>
                                    <option {{($brand->status == 0) ? 'selected': ''}} value="0">inactive</option>
                                </select>
                            </div>
                            

                            <input type="submit" class="btn btn-primary" name="submit" value="Update">




                        </form>
                    
                    </div>
                </div>

        </div>

        </div>
    </section>
@endsection