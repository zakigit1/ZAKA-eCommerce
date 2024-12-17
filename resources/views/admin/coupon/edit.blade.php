@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{"$settings->site_name ||Edit Admin Coupon "}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1> Edit Coupon</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.coupons.index')}}">Coupon</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <a href="{{route('admin.coupons.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br>
                    <div class="card">
                        <div class="card-header">
                            <h4> Edit Coupon</h4>
                        
                        </div>
                        <div class="card-body">
                            
                            <form action="{{route('admin.coupons.update',$coupon->id)}}" method="post">

                                @csrf
                                @method('PUT')

                                
                                <div class="form-group">
                                    <label for="type">Coupon Name</label>
                                    <input type="text" name="name" class="form-control"  placeholder="Coupon Name" value="{{$coupon->name}}">
                                </div>

                                <div class="form-group">
                                    <label for="type">Coupon Code</label>
                                    <input type="text" name="code" class="form-control"  placeholder="Coupon Code" value="{{$coupon->code}}">
                                </div>

                                <div class="form-group">
                                    <label for="type">Quantity</label>
                                    <input type="text" name="quantity" class="form-control"  placeholder="Quantity" value="{{$coupon->quantity}}">
                                </div>

                                <div class="form-group">
                                    <label for="type">Max Use Per Person</label>
                                    <input type="text" name="max_use" class="form-control"  placeholder="Max Use" value="{{$coupon->max_use}}">
                                </div>

                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Start Date</label>
                                            <input type="text" name="start_date" class="form-control datepicker" value="{{$coupon->strat_date}}" >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >End Date</label>
                                            <input type="text" name="end_date" class="form-control datepicker" value="{{$coupon->end_date}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Discount Type</label>
                                            <select class="form-control" name="discount_type">
                                                <option selected disabled>-- Select --</option>
                                                <option {{($coupon->discount_type == 'percent') ? 'selected' : ''}} value="percent">Percentage (%)</option>
                                                <option {{($coupon->discount_type == 'amount') ? 'selected' : ''}} value="amount">Amount ({{$settings->currency_icon}})</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Discount Value</label>
                                            <input type="text" name="discount" class="form-control"  placeholder="Discount Value" value="{{$coupon->discount}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group ">
                                    <label >Status</label>
                                    <select class="form-control"  placeholder="Status" name="status">
                                        <option selected disabled>-- Select --</option>
                                        <option {{($coupon->status == 1) ? 'selected' : ''}} value="1">active</option>
                                        <option {{($coupon->status == 0) ? 'selected' : ''}} value="0">inactive</option>
                                    </select>
                                </div>
                                

                                <input type="submit" class="btn btn-primary"  value="Update">

                            </form>
                        
                        </div>
                    </div>

            </div>
        </div>
    </section>
@endsection