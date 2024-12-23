@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ @$settings->site_name ." || Product Image Gallery  " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.product.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Manage Product Images</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.product.index') }}">Products</a></div>
                <div class="breadcrumb-item">Product Image gallery</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">

                    {{-- <a href="{{ route('admin.product.index') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> Back</a><br>
                    <br><br> --}}

                    <div class="card">
                        <div class="card-header">
                            <h4>Product : <b> {{ $product->name }}</b></h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.product-image-gallery.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="form-group">
                                    <label> Upload Image <code>(multiple image supported!!)</code></label> <br>
                                    <input type="file" name="image[]" multiple>
                                </div>

                                <button class="btn btn-primary" type="submit">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>Gallery Of <b>{{ $product->name }} </b></h4>
                            <div class="card-header-action">
                                <a class="btn btn-danger delete-item-with-ajax"
                                    href="{{ route('admin.product-image-gallery.destroy-all-images', $product->id) }}"><i
                                        class="fas fa-trash-alt"></i> Delete Gallery </a>
                            </div>
                        </div>


                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection


@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
