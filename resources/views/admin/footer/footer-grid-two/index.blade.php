@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Footer Grid Two " }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Manage Footer Grid Two</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Footer Grid Two</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>Footer Grid Two Title</h4>
                        </div>


                        <div class="card-body">
                            <form action="{{ route('admin.footer-grid-two.change-title') }}" method="POST">
                                @csrf
                                @method('PUT')


                                <div class="col-4">

                                    <div class="form-group d-flex">
                                        <input type="text" class="form-control" name="title"
                                            value="{{ @$footerGridTwoTitle }}">
                                        <button type="submit" class="btn btn-primary ml-3">Save</button>
                                    </div>

                                </div>





                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>



    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                    {{-- <div class="container"> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Footer Grid Two Information</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.footer-grid-two.create') }}" class="btn btn-primary"> <i
                                        class="fas fa-plus"></i> Create New</a>
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



    <!-- Change Status ajax : -->
    <script>
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.footer-grid-two.change-status') }}',
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
                        console.log('error');
                    }
                });
            });
        });
    </script>
@endpush
