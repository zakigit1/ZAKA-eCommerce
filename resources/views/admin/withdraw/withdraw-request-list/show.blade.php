@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Withdraw Request Details " }}
@endsection



@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>

            <h1>Withdraw Vendor Request Informations</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.withdraw-request-list.index') }}">Withdraw
                        Vendors Request List</a></div>
                <div class="breadcrumb-item">Withdraw Vendor Request Informations</div>
            </div>
        </div>

        <div class="section-body">
            {{-- <a href="{{ route('admin.withdraw-request-list.index') }}" class="btn btn-primary"> <i
                    class="fas fa-chevron-circle-left"></i> Back</a>
            <br><br> --}}


            <div class="row">
                <div class="col-12 ">
                    {{-- <div class="container"> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Withdraw Vendor Request </h4>
                            <div class="card-header-action">
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                {{-- <table class="table table-striped table-hover table-md"> --}}
                                {{-- <div class="d-flex justify-content-center"> --}}
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Vendor Name</th>
                                        <td>{{ $withdrawRequest->vendor->shop_name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Withdraw Method </th>
                                        <td>{{ $withdrawRequest->method->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Withdraw Charge {{-- رسوم السحب --}} </th>
                                        <td>{{ ($withdrawRequest->withdraw_charge / $withdrawRequest->total_amount) * 100 }}
                                            %</td>
                                    </tr>
                                    <tr>
                                        <th>Withdraw Charge Amount {{-- مبلغ رسوم السحب --}}</th>
                                        <td>{{ $settings->currency_icon . $withdrawRequest->withdraw_charge }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount {{-- المبلغ الإجمالي --}} </th>
                                        <td>{{ $settings->currency_icon . $withdrawRequest->total_amount }}</td>
                                    </tr>
                                    <tr>
                                        <th>Withdraw Amount {{-- المبلغ الذي يمكن سحبه بعد أخد الرسوم السحب --}}</th>
                                        <td>{{ $settings->currency_icon . $withdrawRequest->withdraw_amount }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of withdrawal request {{-- المبلغ الذي يمكن سحبه بعد أخد الرسوم السحب --}}</th>
                                        <td>{{ date('M d ,Y', strtotime($withdrawRequest->created_at)) }}</td>
                                    </tr>

                                    <tr>
                                        <th>Your Request Status </th>
                                        <td>
                                            @if ($withdrawRequest->status == 'paid')
                                                <span class="badge badge-success">Paid</span>
                                            @elseif($withdrawRequest->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($withdrawRequest->status == 'decline')
                                                <span class="badge badge-danger">decline</span>
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>Your Information </th>
                                        <td>{!! $withdrawRequest->account_information !!}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <h5 for="">Change Withdraw Request Status :</h5>
                            <select class='form-control col-md-4 change_withrow_status' data-id={{ $withdrawRequest->id }}>
                                <!-- <option {{ $withdrawRequest->status == 'pending' ? 'selected' : '' }} value='pending'> Pending </option>
                                            <option {{ $withdrawRequest->status == 'paid' ? 'selected' : '' }} value='paid'> Paid </option>
                                            <option {{ $withdrawRequest->status == 'decline' ? 'selected' : '' }} value='decline'> Decline </option> -->
                                <option @selected($withdrawRequest->status == 'pending' ? 'selected' : '') value='pending'> Pending </option>
                                <option @selected($withdrawRequest->status == 'paid' ? 'selected' : '') value='paid'> Paid </option>
                                <option @selected($withdrawRequest->status == 'decline' ? 'selected' : '') value='decline'> Decline </option>
                            </select>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        </div>
        {{-- add change status --}}

    </section>
@endsection


@push('scripts')
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
                            window.location.reload();

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
