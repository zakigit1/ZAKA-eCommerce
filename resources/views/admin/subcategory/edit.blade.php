@extends('Admin.Dashboard.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Edit Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.category.index')}}">Categories</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                    <h4>Edit Category</h4>

                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.sub-category.update',$subcategory->id)}}" method="post" >
                            @csrf
                            @method('PUT')

                            {{-- <input type="hidden" name="id" > --}}


                            <div class="form-group ">
                                <label for="inputStatus">Categories</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="category">
                                   
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{($category->id== $subcategory->category_id ) ? 'selected' : ''}}>{{$category->name}}</option>
                                    @endforeach
                                 
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type">Subcategory Name</label>
                                <input type="text" name="name" class="form-control" id="" placeholder="Subcategory Name" value="{{$subcategory->name}}">
                            </div>

                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                    
                                    <option @if($subcategory->status) selected @endif value="1">active</option>
                                    <option {{($subcategory->status == 0) ? 'selected' : '' }} value="0">inactive</option>
                                    
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