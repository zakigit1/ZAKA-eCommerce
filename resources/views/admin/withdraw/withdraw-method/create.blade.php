@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Create Withdraw Method  " }}
@endsection


@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.withdraw-method.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Add New Withdraw Method</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.withdraw-method.index') }}">Withdraw Method</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            {{-- <a href="{{ route('admin.withdraw-method.index') }}" class="btn btn-primary"> <i
                    class="fas fa-chevron-circle-left"></i> Back</a>

            <br><br> --}}


            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create New Withdraw Method</h4>
                            <div class="card-header-action">
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.withdraw-method.store') }}" method="post">
                                @csrf


                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                        value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label>Minimum Amount</label>
                                    <input type="text" name="minimum_amount" class="form-control"
                                        placeholder="Minimum Amount" value="{{ old('minimum_amount') }}">
                                </div>

                                <div class="form-group">
                                    <label>Maximum Amount</label>
                                    <input type="text" name="maximum_amount" class="form-control"
                                        placeholder="Maximum Amount" value="{{ old('maximum_amount') }}">
                                </div>

                                <div class="form-group">
                                    <label>Withdraw Charge (%)</label>
                                    <input type="text" name="withdraw_charge" class="form-control"
                                        placeholder="Withdraw Charge" value="{{ old('withdraw_charge') }}">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="summernote">{{ old('description') }}</textarea>
                                </div>




                                <input type="submit" class="btn btn-primary" value="Create">
                            </form>

                        </div>
                    </div>

                </div>

            </div>
    </section>
@endsection
