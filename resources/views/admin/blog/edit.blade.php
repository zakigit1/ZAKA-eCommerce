@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Edit Blog " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.blog.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>

            <h1>Edit Blog </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blogs</a></div>
                <div class="breadcrumb-item">Update</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">
                    {{-- <a href="{{ route('admin.blog.index') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}

                    <div class="card">
                        <div class="card-header">
                            <h4>Update Blog</h4>

                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.blog.update', $blog->id) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf
                                @method('PUT')


                                <div class="form-group">
                                    <label>Preview </label><br>
                                    <img width="200px" src="{{ $blog->image }}" alt="blog-img">
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Blog Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Blog Title"
                                        value="{{ $blog->title }}">
                                </div>



                                <div class="form-group">
                                    <label>Blog Categories</label>
                                    <select class="form-control " name="blog_category">

                                        @foreach ($blogCategories as $blogCategory)
                                            <option value="{{ $blogCategory->id }}"
                                                {{ $blogCategory->id == $blog->blog_category_id ? 'selected' : '' }}>
                                                {{ $blogCategory->name }}</option>
                                        @endforeach

                                    </select>
                                </div>




                                <div class="form-group">
                                    <label for="">Blog Description</label>
                                    <textarea name="description" class="form-control summernote" cols="30" rows>{!! $blog->description !!}</textarea>
                                </div>




                                <div class="form-group">

                                    <label>Seo Title</label>
                                    <input type="text" name="seo_title" class="form-control"
                                        value="{{ $blog->seo_title }}">

                                </div>

                                <div class="form-group">

                                    <label>Seo Description</label>
                                    <textarea name="seo_description" class="form-control" rows="3">{!! $blog->seo_description !!}</textarea>

                                </div>




                                <div class="form-group ">
                                    <label for="inputStatus">Status</label>
                                    <select class="form-control" id="inputStatus" placeholder="Status" name="status">

                                        <option @if ($blog->status == 1) selected @endif value="1">active
                                        </option>
                                        <option {{ $blog->status == 0 ? 'selected' : '' }} value="0">inactive
                                        </option>

                                    </select>
                                </div>


                                <input type="submit" class="btn btn-primary" value="Update">




                            </form>

                        </div>
                    </div>

                </div>

            </div>
    </section>
@endsection


@push('scripts')
@endpush
