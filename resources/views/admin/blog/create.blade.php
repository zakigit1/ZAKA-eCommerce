@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Create Admin Blog "}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Add New Blog</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.blog.index')}}">Blogs</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <a href="{{route('admin.blog.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                <br><br>
                <div class="card">
                    <div class="card-header">
                        <h4>Create New Blog</h4>

                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.blog.store')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="image">Blog Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>


                            <div class="form-group">
                                <label for="">Blog Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Blog Title" value="{{old('title')}}">
                            </div>



                            <div class="form-group">
                                <label >Blog Categories</label>
                                <select class="form-control"  name="blog_category">
                                
                                    <option selected disabled>-- Select --</option>

                                    @foreach ($blogCategories as $blogCategory)
                                    <option value="{{$blogCategory->id}}">{{$blogCategory->name}}</option>
                                    @endforeach
                                
                                </select>
                            </div>
                         

                            <div class="form-group">
                                <label >Blog  Description</label>
                                <textarea name="description" class="form-control summernote" >{{old('description')}}</textarea>

                            </div>


 
                            <div class="form-group">
                                
                                <label >Seo Title</label>
                                <input type="text" name="seo_title" class="form-control" value="{{old('seo_title')}}">
                                
                            </div>
                            <div class="form-group">
                                
                                <label >Seo Description</label>
                                <textarea name="seo_description" class="form-control" rows="3">{{old('seo_description')}}</textarea>
                                
                            </div>
                            


                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control"  name="status">
                                    <option selected disabled>-- Select --</option>
                                    <option value="1">active</option>
                                    <option value="0">inactive</option>
                                </select>
                            </div>
                            

                            <input type="submit" class="btn btn-primary"  value="Create">

                        </form>
                    
                    </div>
                </div>

        </div>

        </div>
    </section>
@endsection


@push('scripts')
@endpush