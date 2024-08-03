@extends('Admin.Dashboard.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Add New Sub Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.category.index')}}">Sub Categories</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <a href="{{route('admin.sub-category.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                <div class="card">
                    <div class="card-header">
                        <h4>Create New Sub Category</h4>

                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.sub-category.store')}}" method="post" >
                            @csrf



                            <div class="form-group ">
                                <label for="inputStatus">Categories</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="category">
                                    <option selected disabled>-- Select --</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                 
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type">SubCategory Name</label>
                                <input type="text" name="name" class="form-control" id="" placeholder="Category Name" value="{{old('name')}}">
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