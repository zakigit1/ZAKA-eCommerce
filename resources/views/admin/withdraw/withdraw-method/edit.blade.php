@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Edit Admin Withdraw Method  " }}
@endsection


@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.withdraw-method.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Edit Withdraw Method</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.withdraw-method.index') }}">Withdraw Method</a></div>
                <div class="breadcrumb-item">Edit</div>
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
                            <h4>Edit Withdraw Method</h4>
                            <div class="card-header-action">
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.withdraw-method.update', $withdrawMethod->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <br>
                                <div class="form-group">
                                    <label>Withdraw Method Name</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Withdraw Method Name" value="{{ $withdrawMethod->name }}">
                                </div>

                                <div class="form-group">
                                    <label>Minimum Amount</label>
                                    <input type="text" name="minimum_amount" class="form-control"
                                        placeholder="Minimum Amount" value="{{ $withdrawMethod->minimum_amount }}">
                                </div>

                                <div class="form-group">
                                    <label>Maximum Amount</label>
                                    <input type="text" name="maximum_amount" class="form-control"
                                        placeholder="Maximum Amount" value="{{ $withdrawMethod->maximum_amount }}">
                                </div>

                                <div class="form-group">
                                    <label>Withdraw Charge (%)</label>
                                    <input type="text" name="withdraw_charge" class="form-control"
                                        placeholder="Withdraw Charge" value="{{ $withdrawMethod->withdraw_charge }}">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="summernote"
                                        placeholder="Enter A Description Contient A rules About Withdraw Charge">{{ $withdrawMethod->description }}</textarea>
                                </div>




                                <input type="submit" class="btn btn-primary" value="Update">
                            </form>

                        </div>
                    </div>

                </div>

            </div>
    </section>
@endsection
