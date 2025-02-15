@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name . ' || Create Admin Product' }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.product.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Add New Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Admin Products</a></div>
                <div class="breadcrumb-item">Create</div>
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
                            <h4>Create New Product</h4>

                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="thumb_image" class="form-control" placeholder="Thumb Image">
                                </div>
                                <div class="form-group">
                                    <label for="">Product Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        placeholder="Product Name" value="{{ old('name') }}">
                                </div>


                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Categories</label>
                                            <select class="form-control  main-category" name="category">

                                                <option selected disabled>-- Select --</option>
                                                @if (isset($categories) && count($categories) > 0)
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                @endif


                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sub Categories</label>
                                            <select class="form-control sub-category" name="subcategory">

                                                <option selected disabled>-- Select --</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Child Categories</label>
                                            <select class="form-control child-category" name="childcategory">

                                                <option selected disabled>-- Select --</option>

                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label>Brands</label>
                                    <select class="form-control mt-6" name="brand">

                                        <option selected disabled>-- Select --</option>
                                        @if (isset($brands) && count($brands) > 0)
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="">SKU</label>
                                    <input type="text" name="sku" class="form-control" id=""
                                        placeholder="SKU" value="{{ old('sku') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" name="price" class="form-control" id=""
                                        placeholder="Price" value="{{ old('price') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Offer Price</label>
                                    <input type="text" name="offer_price" class="form-control" id=""
                                        placeholder="Offer Price" value="{{ old('offer_price') }}">
                                </div>


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>Offer Start Date</label>
                                            <input type="text" name="offer_start_date" class="form-control datepicker"
                                                value="{{ old('offer_start_date') }}">
                                            {{-- <input type="text" name="offer_start_date" class="form-control datepicker" value="{{ Carbon\Carbon::now()}}"> --}}
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>Offer End Date</label>
                                            <input type="text" name="offer_end_date" class="form-control datepicker"
                                                value="{{ old('offer_end_date') }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="">Stock Quantity</label>
                                    <input type="number" min="0" name="qty" class="form-control" id=""
                                        placeholder="Stock Quantity" value="{{ old('qty') }}">
                                </div>

                                <div class="form-group">
                                    <label for="btn_url">Product Video</label>
                                    <input type="text" name="video_link" class="form-control" id="btn_url"
                                        placeholder="Video Link" value="{{ old('video_link') }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Short Description</label>
                                    <textarea name="short_description" class="form-control" id="">{{ old('short_description') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Long Description</label>
                                    <textarea name="long_description" class="form-control summernote">{{ old('long_description') }}</textarea>

                                </div>


                                <div class="form-group">
                                    <label>Product Type</label>
                                    <select class="form-control" name="product_type">

                                        <option selected disabled>-- Select --</option>

                                        <option value="new_arrival">New Arrival</option>
                                        <option value="featured_product">Featured</option>
                                        <option value="top_product">Top</option>
                                        <option value="best_product">Best</option>

                                    </select>
                                </div>

                                <div class="form-group">

                                    <label>Seo Title</label>
                                    <input type="text" name="seo_title" class="form-control"
                                        value="{{ old('seo_title') }}">

                                </div>
                                <div class="form-group">

                                    <label>Seo Description</label>
                                    <textarea name="seo_description" class="form-control" rows="3">{{ old('seo_description') }}</textarea>

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


@push('scripts')
    <script>
        $(document).ready(function() {

            //              get sub categories : 

            $('body').on('change', '.main-category', function(e) {



                let id = $(this).val();

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.product.get-sub-categories') }}',
                    data: {
                        category_id: id,
                    },
                    success: function(data) {
                        //this line to reset the sub-categories when you change the category  
                        $('.sub-category').html('<option selected value="">Select</option>');
                        //this line to reset the child-categories when you change the category  
                        $('.child-category').html('<option selected value="">Select</option>');

                        $.each(data, function(i, item) {
                            // $('.sub-category').append('<option value="'+item.id+'">'+item.name+'</option>');

                            $('.sub-category').append(
                                `<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);

                        if (xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value);
                            })
                        } else if (xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('An unknown error occurred.');
                        }
                    }
                });
            });

            //              get child categories : 

            $('body').on('change', '.sub-category', function(e) {

                let id = $(this).val();

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.product.get-child-categories') }}',
                    data: {
                        sub_category_id: id,
                    },
                    success: function(data) {
                        $('.child-category').html('<option selected value="">Select</option>');

                        $.each(data, function(i, item) {

                            $('.child-category').append(
                                `<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);

                        if (xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value);
                            })
                        } else if (xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('An unknown error occurred.');
                        }
                    }
                });
            });
        });
    </script>
@endpush
