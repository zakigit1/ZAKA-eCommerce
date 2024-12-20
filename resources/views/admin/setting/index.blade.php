@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Settings " }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Manage Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Settings</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('settings_view_list') && session()->get('settings_view_list') == 'general-settings' ? 'active' : '' }} 
                                    {{ !session()->has('settings_view_list') ? 'active' : '' }}"
                                            data-id="general-settings" id="list-home-list" data-toggle="list"
                                            href="#list-home" role="tab">General Settings</a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('settings_view_list') && session()->get('settings_view_list') == 'email-configuration' ? 'active' : '' }}"
                                            data-id="email-configuration" id="list-profile-list" data-toggle="list"
                                            href="#list-profile" role="tab">Email Configuration</a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('settings_view_list') && session()->get('settings_view_list') == 'pusher-configuration' ? 'active' : '' }}"
                                            data-id="pusher-configuration" id="list-settings-list" data-toggle="list"
                                            href="#list-settings" role="tab">Pusher Configuration</a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('settings_view_list') && session()->get('settings_view_list') == 'logo-settings' ? 'active' : '' }}"
                                            data-id="logo-settings" id="list-messages-list" data-toggle="list"
                                            href="#list-messages" role="tab">Logo & Favicon Settings</a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">

                                        <div class="tab-pane fade {{ session()->has('settings_view_list') && session()->get('settings_view_list') == 'general-settings' ? 'show active' : '' }} 
                                {{ !session()->has('settings_view_list') ? 'show active' : '' }}"
                                            id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                            @include('admin.setting.includes.general-setting')
                                        </div>


                                        <div class="tab-pane fade {{ session()->has('settings_view_list') && session()->get('settings_view_list') == 'email-configuration' ? 'show active' : '' }}"
                                            id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                            @include('admin.setting.includes.email-configuration')
                                        </div>


                                        <div class="tab-pane fade {{ session()->has('settings_view_list') && session()->get('settings_view_list') == 'logo-settings' ? 'show active' : '' }}"
                                            id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                                            @include('admin.setting.includes.logo-and-favicon')
                                        </div>

                                        <div class="tab-pane fade {{ session()->has('settings_view_list') && session()->get('settings_view_list') == 'pusher-configuration' ? 'show active' : '' }}"
                                            id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                                            @include('admin.setting.includes.pusher-configuration')
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


@push('scripts')
    <script>
        $(document).ready(function() {

            $('.list-view').on('click', function() {

                let style = $(this).data('id');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.settings.view-list') }}',
                    data: {
                        style: style,
                    },
                    success: function(data) {

                    }
                });
            });

        });
    </script>
@endpush
