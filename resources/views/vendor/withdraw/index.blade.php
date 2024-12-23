@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Withdraw Requests " }}
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
                <h3><i class="far fa-user"></i>Vendor Withdraw Request </h3>


                <div class="wsus__dashboard">
                    <div class="row">

                        <div class="col-md-4">
                            <a class="wsus__dashboard_item green" href="javascript:;">
                                <i class="far fa-money-bill-wave"></i>
                                <p>Current balance {{-- الرصيد الحالي --}}</p>
                                <h4 style="color: white">{{ $settings->currency_icon . $currentBalance }}</h4>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a class="wsus__dashboard_item green" href="javascript:;">
                                <i class="far fa-money-bill-wave"></i>
                                <p>Pending Amount {{-- المبلغ المعلق --}}</p>
                                <h4 style="color: white">{{ $settings->currency_icon . $pendingWithdraw }}</h4>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a class="wsus__dashboard_item green" href="javascript:;">
                                <i class="far fa-money-bill-wave"></i>
                                <p>Total Withdraw {{-- إجمالي السحب --}}</p>
                                <h4 style="color: white">{{ $settings->currency_icon . $totalWithdraw }}</h4>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">
                        <div class="create_button">
                            <a href="{{ route('vendor.withdraw.create') }}" class="btn btn-primary"> <i
                                    class="fas fa-plus"></i> Add Withdraw Request</a>
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
