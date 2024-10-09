@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Admin Vendors Request Pending "}}
@endsection



@section('content')


    <section class="section">
        <div class="section-header">
            <h1>Manage Vendors Request</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Vendor Request Pending</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Vendors Request Pending</h4>
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