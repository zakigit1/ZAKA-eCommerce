@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Admin Child Category " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Manage Child Categories</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Child-Categories</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                    {{-- <div class="container"> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>All Child Categories</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.child-category.create') }}" class="btn btn-primary"> <i
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



    {{-- !      modification need for this part of ajax code dirha bl post again  --------------------------- --}}

    <!-- Change Status ajax : -->
    <script>
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.child-category.change-status') }}',
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
                        toastr.success(data
                        .message); // Note the change to toastr.success instead of toastr().success
                        // toastr()->success(data.message);
                    },
                    error: function(xhr, status, error) {
                        console.log('error');
                    }
                });
            });
        });
    </script>
@endpush
