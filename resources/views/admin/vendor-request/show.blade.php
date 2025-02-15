@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name . ' || Vendor Request Details' }}
@endsection



@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.vendor-request.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Vendor Informations</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.vendor-request.index') }}">Vendors Requests</a></div>
                <div class="breadcrumb-item">Vendor Informations</div>
            </div>
        </div>

        <div class="section-body">
            {{-- <a href="{{ route('admin.vendor-request.index') }}" class="btn btn-primary"> <i
                    class="fas fa-chevron-circle-left"></i> Back</a>

            <br><br> --}}

            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Vendor Informations</h2>

                            </div>
                            <hr>

                        </div>
                    </div>


                    <div>
                        {{-- date + time exp : Dec 24,2024 12:47 PM --}}
                        {{-- <h3><b>Request Date : </b><code>{{ $vendor->created_at->format('M d, Y h:i A') }}</code></h3> --}}
                        <h4><b>Request Date : </b><code style="color: rgb(238, 21, 17)">{{ $vendor->created_at->format('M d, Y') }}</code></h4>
                    </div>
                    <br>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>User Information :</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">

                                    <tr>
                                        <th>User Name :</th>
                                        <td>{{ @$vendor->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>User Email :</th>
                                        <td>{{ @$vendor->user->email }}</td>
                                    </tr>

                                </table>
                            </div>

                            <br><br>

                            <h5>User Vendor Information :</h5>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">


                                    <tr>
                                        <th width = "13%">Shop Name :</th>
                                        <td>{{ $vendor->shop_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shop Email :</th>
                                        <td>{{ $vendor->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shop Phone :</th>
                                        <td>{{ $vendor->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shop Address :</th>
                                        <td>{{ $vendor->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shop Descreption :</th>
                                        <td>{{ strip_tags($vendor->description) }}</td>
                                    </tr>

                                </table>
                            </div>

                            <div class="row mt-4">


                                <div class="col-lg-8">
                                    <div class="col-md-5">

                                        @if ($vendor->status == 0)
                                            <form action="{{ route('admin.vendor-request.change-status', $vendor->id) }}"
                                                method="POST">
                                                @csrf


                                                <div class="form-group">
                                                    <label for="">Vendor Status</label>
                                                    <select class="form-control" name="status">

                                                        <option {{ $vendor->status == 0 ? 'selected' : '' }}
                                                            value="0"> Pending </option>
                                                        <option {{ $vendor->status == 1 ? 'selected' : '' }}
                                                            value="1"> Approved </option>

                                                    </select>
                                                </div>

                                                <input type="submit" class="btn btn-primary" value="Update">
                                            </form>
                                        @else
                                            <div class="form-group">
                                                <label for="">Vendor Status</label>
                                                <select class="form-control" name="status">

                                                    <option disabled selected> Approved </option>

                                                </select>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>

        </div>

    </section>
@endsection
