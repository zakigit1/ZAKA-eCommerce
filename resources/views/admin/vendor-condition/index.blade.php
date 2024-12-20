@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ "$settings->site_name || Create A Vendor Condtions" }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Vendor Conditions</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Vendor Conditions</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>Conditions To Be A Vendor</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.vendor-condition.update') }}" method="post">
                                @csrf
                                @method('PUT')




                                <div class="form-group">
                                    <label for="type">Content</label>

                                    <textarea name="condition_content" class="summernote" placeholder="Enter The Conditions To Be A Vendor In The Website">
                                    {!! @$vendor_condition->content !!}
                                </textarea>

                                </div>

                                <input type="submit" class="btn btn-primary" value="Update">




                            </form>

                        </div>
                    </div>

                </div>

            </div>
    </section>
@endsection
