@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{"$settings->site_name || Admin Newsletter Subscribers "}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Subscriber Of Newsletter</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item">Subscriber </div>
        </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                
                    <div class="card">
                        <div class="card-header">
                            <h4>Send Mails</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{route('admin.subscriber.send-mail')}}" method="post">
                                @csrf

                                <div class="form-group">
                                    <label >Subject</label>
                                    <input type="text" name="subject" class="form-control" value="{{old('subject')}}">
                                </div>
                                <div class="form-group">
                                    <label >Message</label><br>
                                    <textarea name="message" class="form-control"  cols="30" rows="10">{{old('message')}}</textarea>
                                </div>

                                <input type="submit" class="btn btn-primary" value="send">

                            </form>
                        </div>
                
                    </div>
                </div>

            </div>

        </div>


        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                
                    <div class="card">
                        <div class="card-header">
                            <h4>All Subscribers</h4>
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