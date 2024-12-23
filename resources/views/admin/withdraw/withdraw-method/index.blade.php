@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Withdraw Methods " }}
@endsection



@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Withdraw Method</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Withdraw Method</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
    
                    <div class="card">
                        <div class="card-header">
                            <h4>Withdraw Method</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.withdraw-method.create') }}" class="btn btn-primary"> <i
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
@endpush
