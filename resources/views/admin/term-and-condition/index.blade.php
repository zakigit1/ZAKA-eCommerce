@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ "$settings->site_name || Create Terms & Conditions " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Terms & Conditions</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Terms & Conditions</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>Terms & Conditions</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.terms-and-conditions.update') }}" method="post">
                                @csrf
                                @method('PUT')


                                <div class="form-group">
                                    <label for="type">Content</label>

                                    <textarea name="termsandconditions_content" class="summernote">
                                    {!! @$termAndCondition->content !!}
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
