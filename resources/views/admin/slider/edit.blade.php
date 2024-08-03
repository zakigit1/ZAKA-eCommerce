@extends('Admin.Dashboard.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Edit Slider</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.slider.index')}}">Sliders</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <a href="{{route('admin.slider.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a><br>
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Slider</h4>

                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.slider.update',$slider->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- <input type="hidden" name="id" > --}}

                            <div class="form-group " >
                                <img height="200"  width="250" src="{{$slider->banner}}" alt="banner-img">
                            </div>
                            <div class="form-group">
                                <label for="image">Banner</label>
                                <input type="file" name="banner" class="form-control" id="banner" placeholder="Banner" >
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" name="type" class="form-control" id="" placeholder="Type" value="{{$slider->type}}">
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="" placeholder="Title" value="{{$slider->title}}">
                            </div>
                            <div class="form-group">
                                <label for="starting_price">Starting Price</label>
                                <input type="text" name="starting_price" class="form-control" id="starting_price" placeholder="Starting Price" value="{{$slider->starting_price}}">
                            </div>
                            <div class="form-group">
                                <label for="btn_url">Button URL</label>
                                <input type="text" name="btn_url" class="form-control" id="btn_url" placeholder="Button URL" value="{{$slider->btn_url}}">
                            </div>
                            <div class="form-group">
                                <label for="serial">Serial</label>
                                <input type="text" name="serial" class="form-control" id="serial" placeholder="Serial" value="{{$slider->serial}}">
                            </div>
                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                    
                                    <option @if($slider->status) selected @endif value="1">active</option>
                                    <option {{($slider->status == 0) ? 'selected' : '' }} value="0">inactive</option>
                                    
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