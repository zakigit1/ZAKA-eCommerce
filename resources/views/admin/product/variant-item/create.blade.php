@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ "$settings->site_name || Create Product Variant Item" }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.product-variant-item.index', [$product->id, $variant->id]) }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Add New Product Variant Item</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.product-variant.index', ['id' => $product->id]) }}">Product Variants</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.product-variant-item.index', [$product->id, $variant->id]) }}">Product Variant Items</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">
                    {{-- <a href="{{ route('admin.product-variant-item.index', [$product->id, $variant->id]) }}"
                        class="btn btn-primary"> <i class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4> Create New Item</h4>

                        </div>
                        <div class="card-body">

                            <form action="{{ route('admin.product-variant-item.store') }}" method="post">

                                @csrf

                                <input type="hidden" name="product_id" value="{{ request()->productId }}">
                                {{-- <input type="hidden" name="product_id" value="{{$product->id}}"> --}}
                                <input type="hidden" name="variant_id" value="{{ request()->variantId }}">
                                {{-- <input type="hidden" name="variant_id" value="{{$variant->id}}"> --}}

                                <div class="form-group">
                                    <label for="type">Variant Name</label>
                                    <input type="text" class="form-control" placeholder="Variant Name"
                                        value="{{ $variant->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="type">Item Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Item Name"
                                        value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="type">Price <code>(Set 0 for make it free)</code></label>
                                    <input type="text" name="price" class="form-control"
                                        placeholder="Price (Set 0 for make it free)" value="{{ old('price') }}">
                                </div>


                                <div class="form-group ">
                                    <label>Is Default</label>
                                    <select class="form-control" name="is_default">
                                        <option selected disabled>-- Select --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
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
