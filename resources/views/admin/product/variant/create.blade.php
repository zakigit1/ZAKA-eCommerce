@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ @$settings->site_name ." || Create Product Variant" }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.product-variant.index', ['id' => request()->product_id]) }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left" style="font-size:25px"></i></a>
            </div>
            <h1>Add New Product Variant</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></div>
                <div class="breadcrumb-item"><a
                        href="{{ route('admin.product-variant.index', ['id' => request()->product_id]) }}">Product
                        Variants</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">
                    {{-- <a href="{{ route('admin.product-variant.index', ['id' => request()->product_id]) }}"
                        class="btn btn-primary"> <i class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4> Create New Variant</h4>

                        </div>
                        <div class="card-body">

                            <form action="{{ route('admin.product-variant.store') }}" method="post">

                                @csrf

                                <input type="hidden" name="product_id" value="{{ request()->product_id }}">

                                <div class="form-group">
                                    <label for="type">Variant Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        placeholder="Variant Name" value="{{ old('name') }}">
                                </div>


                                <div class="form-group ">
                                    <label>Status</label>
                                    <select class="form-control" placeholder="Status" name="status">
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
