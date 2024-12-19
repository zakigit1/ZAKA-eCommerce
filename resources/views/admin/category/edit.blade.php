@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ "$settings->site_name || Edit Admin Category " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.category.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Edit Category</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">
                    {{-- <a href="{{ route('admin.category.index') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}

                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Category</h4>

                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.category.update', $category->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                {{-- <input type="hidden" name="id" > --}}

                                <label for="icon">Category Icon</label>
                                <div class="form-group">
                                    <button id='icon' name="icon" data-icon="{{ $category->icon }}"
                                        class="btn btn-warning " role="iconpicker" data-align="right" data-rows="8"
                                        data-cols="10" data-arrow-class="btn-info "
                                        data-arrow-prev-icon-class="fas fa-angle-left"
                                        data-arrow-next-icon-class="fas fa-angle-right" data-selected-class="btn-danger "
                                        data-unselected-class="btn-success"></button>

                                </div>

                                <div class="form-group">
                                    <label for="type">Category Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        placeholder="Category Name" value="{{ $category->name }}">
                                </div>

                                <div class="form-group ">
                                    <label for="inputStatus">Status</label>
                                    <select class="form-control" id="inputStatus" placeholder="Status" name="status">

                                        <option @if ($category->status) selected @endif value="1">active
                                        </option>
                                        <option {{ $category->status == 0 ? 'selected' : '' }} value="0">inactive
                                        </option>

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
