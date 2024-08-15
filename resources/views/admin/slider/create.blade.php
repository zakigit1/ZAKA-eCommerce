@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{"$settings->site_name ||Create Admin Slider  "}}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Add New Slider</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.slider.index')}}">Sliders</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Create New Slider</h4>
                        <div class="card-header-action">
                            <a href="{{route('admin.slider.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.slider.store')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="image">Banner</label>
                                <input type="file" name="banner" class="form-control" id="banner" placeholder="Banner" >
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" name="type" class="form-control" id="" placeholder="Type" value="{{old('type')}}">
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="" placeholder="Title" value="{{old('title')}}">
                            </div>
                            <div class="form-group">
                                <label for="starting_price">Starting Price</label>
                                <input type="text" name="starting_price" class="form-control" id="starting_price" placeholder="Starting Price" value="{{old('starting_price')}}">
                            </div>
                            <div class="form-group">
                                <label for="btn_url">Button URL</label>
                                <input type="text" name="btn_url" class="form-control" id="btn_url" placeholder="Button URL" value="{{old('btn_url')}}">
                            </div>
                            <div class="form-group">
                                <label for="serial">Serial</label>
                                <input type="text" name="serial" class="form-control" id="serial" placeholder="Serial" value="{{old('serial')}}">
                            </div>
                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                    <option selected disabled>-- Select --</option>
                                    <option value="1">active</option>
                                    <option value="0">inactive</option>
                                </select>
                            </div>
                            

                            <input type="submit" class="btn btn-primary" name="submit" value="Create">




                        </form>
                    
                    </div>
                </div>

        </div>

        </div>
    </section>
@endsection