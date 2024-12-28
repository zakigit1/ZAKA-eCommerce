@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ @$settings->site_name . ' || Flash Sale ' }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Flash Sale</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Flash Sale</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>End Flash Sale</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.flash-sale.end_date') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>End Date</label>

                                    <input type="text" name="end_date" class="form-control datepicker"
                                        value="{{ @$flash_end_date->end_date }}">
                                </div>
                                <input type="submit" class="btn btn-primary" name="save" value="Save">
                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>Add Flash Sale Products </h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('admin.flash-sale.add_product') }}" method="post">

                                @csrf
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label>Products </label>
                                            <select class="form-control select2" name="product">
                                                <option value="" selected disabled> -- Select --</option>
                                                @if (isset($products) && count($products) > 0)
                                                    @foreach ($products as $product)
                                                        {{-- <option value="{{ $product->id }}">{{ $product->name }}</option> --}}
                                                        <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>show at home ? </label>
                                            <select class="form-control" name="show_at_home">
                                                <option selected disabled>-- Select --</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>

                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select class="form-control" name="status">
                                                <option selected disabled>-- Select --</option>
                                                <option value="1">active</option>
                                                <option value="0">inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <input type="submit" class="btn btn-primary" name="save" value="Save">
                            </form>

                        </div>

                    </div>
                </div>

            </div>

        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>All Flash Sale Item</h4>
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

    <!-- -->
    <script>
        $(document).ready(function() {

            // Change Status ajax :
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.flash-sale.change-status') }}',
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                            'content'), // Include the CSRF token in the data
                        status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        // Note the change to toastr.success instead of toastr().success
                        if (data.status == 'success') {
                            toastr.success(data.message);
                        } else if (data.status == 'error') {
                            toastr.warning(data.message);

                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
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

            //  Change show at home status ajax :
            $('body').on('click', '.change-at-home-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.flash-sale.change-at-home-status') }}',
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                            'content'), // Include the CSRF token in the data
                        show_at_home_status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        // Note the change to toastr.success instead of toastr().success
                        if (data.status == 'success') {
                            toastr.success(data.message);
                        } else if (data.status == 'error') {
                            toastr.warning(data.message);

                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
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
