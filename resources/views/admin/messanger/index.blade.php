@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Admin Messanger " }}
@endsection

@section('content')
    <section class="section">

        <div class="section-header">
            <h1>Messanger</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{url('/admin/dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Conversion</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row align-items-center justify-content-center">
                <div class="col-md-3">
                    <div class="card" style="height: 70vh">
                        <div class="card-header">
                            <h4>Users</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @if(isset($clientsInfo) && count($clientsInfo) > 0)
                                    @foreach($clientsInfo as $clientInfo)
                                        <li class="media">
                                            <img alt="image" class="mr-3 rounded-circle" width="50"
                                                src="{{$clientInfo->senderProfile->image}}">
                                            <div class="media-body">
                                                <div class="mt-0 mb-1 font-weight-bold">{{$clientInfo->senderProfile->name}}</div>
                                                {{-- <div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i>
                                                    Online</div> --}}
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card chat-box" id="mychatbox" style="height: 70vh">
                        <div class="card-header">
                            <h4>Chat with Rizal</h4>
                        </div>

                        <div class="card-body chat-content">
                            <div class="chat-item chat-right" style=""><img src="../dist/img/avatar/avatar-2.png">
                                <div class="chat-details">
                                    <div class="chat-text">Wat?!</div>
                                    <div class="chat-time">02:06</div>
                                </div>
                            </div>


                            <div class="chat-item chat-left" style="">
                                <img src="../dist/img/avatar/avatar-1.png">
                                <div class="chat-details">
                                    <div class="chat-text">You wanna know?</div>
                                    <div class="chat-time">02:06</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer chat-form">
                            <form id="chat-form">
                                <input type="text" class="form-control" placeholder="Type a message">
                                <button class="btn btn-primary">
                                    <i class="far fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script></script>
@endpush
