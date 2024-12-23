@extends('vendor.Dashboard.layouts.master')

@section('title')
        {{ @$settings->site_name ." || Orders " }}
@endsection



@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <div class="back_button">
                    <a href="{{ route('vendor.dashboard') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> back</a>
                </div>
                <br>

                <h3><i class="far fa-user"></i> Manage Vendor Orders</h3>

                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        <div class="create_button">
                            <a href="{{ route('vendor.order.trashed-orders') }}" class="btn btn-danger"> <i
                                    class="fas fa-dumpster"></i> Trashed Orders</a>
                        </div>
                        <div class="card">

                            <div class="card-body">
                                {{ $dataTable->table() }}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
