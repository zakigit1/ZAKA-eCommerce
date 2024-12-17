@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{"$settings->site_name || Edit Admin Blog Category "}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Edit Blog Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.blog-category.index')}}">Categories</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <a href="{{route('admin.blog-category.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                
                <br><br>

                <div class="card">
                    <div class="card-header">
                        <h4>Edit Blog Category</h4>

                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.blog-category.update',$blogCategory->id)}}" method="post" >
                            @csrf
                            @method('PUT')



                            <div class="form-group">
                                <label for="type">Category Name</label>
                                <input type="text" name="name" class="form-control" id="" placeholder="Blog Category Name" value="{{$blogCategory->name}}">
                            </div>

                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                    
                                    <option @if($blogCategory->status) selected @endif value="1">active</option>
                                    <option {{($blogCategory->status == 0) ? 'selected' : '' }} value="0">inactive</option>
                                    
                                </select>
                            </div>
                            

                            <input type="submit" class="btn btn-primary"  value="Update">


                        </form>
                    
                    </div>
                </div>

        </div>

        </div>
    </section>
@endsection