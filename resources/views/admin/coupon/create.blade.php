@extends('Admin.Dashboard.layouts.master')


@section('title')
    {{ "$settings->site_name || Create Coupon " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Add New Coupon</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    {{-- <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4> Create Coupon</h4>

                        </div>
                        <div class="card-body">

                            <form action="{{ route('admin.coupons.store') }}" method="post">

                                @csrf


                                <div class="form-group">
                                    <label for="type">Coupon Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Coupon Name"
                                        value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="type">Coupon Code</label>
                                    <input type="text" name="code" class="form-control" placeholder="Coupon Code"
                                        value="{{ old('code') }}">
                                </div>
                                <div class="form-group">
                                    <label for="type">Quantity</label>
                                    <input type="number" min="0" max="1000" name="quantity" class="form-control"
                                        placeholder="Quantity" value="{{ old('quantity') }}">
                                </div>
                                <div class="form-group">
                                    <label for="type">Max Use Per Person</label>
                                    <input type="number" min="1" max="20" name="max_use" class="form-control"
                                        placeholder="Max Use" value="{{ old('max_use') }}">
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="text" name="start_date" class="form-control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="text" name="end_date" class="form-control datepicker">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Discount Type</label>
                                            <select class="form-control" name="discount_type">
                                                <option selected disabled>-- Select --</option>
                                                <option value="percent">Percentage (%)</option>
                                                <option value="amount">Amount ({{ $settings->currency_icon }})</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="type">Discount Value</label>
                                            <input type="text" name="discount" class="form-control"
                                                placeholder="Discount Value" value="{{ old('discount') }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group ">
                                    <label>Status</label>
                                    <select class="form-control" placeholder="Status" name="status">
                                        <option selected disabled>-- Select --</option>
                                        <option value="1">active</option>
                                        <option value="0">inactive</option>
                                    </select>
                                </div>


                                <input type="submit" class="btn btn-primary" value="Create">

                            </form>

                        </div>
                    </div>

                </div>
            </div>
    </section>
@endsection
