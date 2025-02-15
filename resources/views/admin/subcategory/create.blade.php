@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ @$settings->site_name ." || Create Sub Category " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.sub-category.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Add New Sub-Category</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.sub-category.index') }}">Sub-Categories</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                    {{-- <a href="{{ route('admin.sub-category.index') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}

                    <div class="card">
                        <div class="card-header">
                            <h4>Create New Sub Category</h4>

                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.sub-category.store') }}" method="post">
                                @csrf



                                <div class="form-group ">
                                    <label for="inputStatus">Categories</label>
                                    <select class="form-control" id="inputStatus" placeholder="Status" name="category">
                                        <option selected disabled>-- Select --</option>
                                        @if (isset($categories) && count($categories)>0)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="type">SubCategory Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        placeholder="Category Name" value="{{ old('name') }}">
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
