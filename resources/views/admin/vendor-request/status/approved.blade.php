@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Vendors Requests Approved" }}
@endsection



@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.vendor-request.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1> Vendors Requests Approved</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.vendor-request.index') }}">Vendors Requests</a>
                </div>
                <div class="breadcrumb-item">Vendors Requests Approved</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Vendors Request Approved</h4>
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
