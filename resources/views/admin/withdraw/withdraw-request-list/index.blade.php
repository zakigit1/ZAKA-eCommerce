@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name ||  Withdraw Request List " }}
@endsection



@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Withdraw Vendors Request List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Withdraw Vendors Request List</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>Withdraw Request List</h4>
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
    <script>
        $(document).ready(function() {

            // Change Approve Status ajax : 
            $('body').on('change', '.change_withrow_status', function() {
                let value = $(this).val();
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.withdraw-request-change-status') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                        'content'), // Include the CSRF token in the data
                        status: value,
                        id: id
                    },
                    success: function(data) {
                        // Note the change to toastr.success instead of toastr().success
                        if (data.status == 'success') {
                            toastr.success(data.message)
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);

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
