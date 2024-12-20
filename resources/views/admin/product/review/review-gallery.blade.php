@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Product Review Gallery" }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.product-review.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Manage Product Review Gallery</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.product.index') }}">Products</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.product-review.index') }}">Products Reviews</a>
                </div>
                <div class="breadcrumb-item">Product Review Gallery </div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 ">
                    {{-- <a href="{{ route('admin.product-review.index') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Review Gallery</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tr>

                                    <th>Id</th>
                                    <th>Images</th>
                                    <th>Action</th>
                                </tr>

                                @foreach ($productReview->productReviewGalleries as $image)
                                    <tr>

                                        <td>{{ $image->id }}</td>

                                        <td>
                                            <img width="200px" src="{{ $image->image }}"
                                                alt="{{ $productReview->product->name }}-img">
                                        </td>
                                        <td>
                                            <a class="btn btn-danger delete-item-with-ajax"
                                                href="{{ route('admin.product-review-gallery.destroy', $image->id) }}"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="card-body">

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection














@push('scripts')
    <script>
        $(document).ready(function() {
            //  <!-- Change Order Status ajax : -->
            $('#order_status').on('change', function() {
                let status = $(this).val();
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.order.change-order-status') }}',
                    method: 'GET',
                    data: {
                        status: status,
                        id: id
                    },
                    success: function(data) {

                        if (data.status == 'success') {
                            toastr.success(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error');
                    }
                });
            });
        });
    </script>
@endpush
