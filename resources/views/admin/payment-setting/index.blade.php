@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Admin Payment Settings  " }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Setting</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>Payment Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="list-group" id="list-tab" role="tablist">

                                        <a class="list-group-item list-group-item-action list-view {{session()->has('payment_settings_view_list') && session()->get('payment_settings_view_list') == 'paypal-settings' ? 'active' : ''}}
                                            {{!session()->has('payment_settings_view_list') ? 'active' : '' }}" 
                                            data-id="paypal-settings" 
                                            id="list-paypal-list"
                                            data-toggle="list" href="#list-paypal" role="tab">
                                            Paypal Payment
                                        </a>
                                        <a class="list-group-item list-group-item-action list-view {{session()->has('payment_settings_view_list') && session()->get('payment_settings_view_list') == 'stripe-settings' ? 'active' : ''}}"  
                                            data-id="stripe-settings" 
                                            id="list-stripe-list"
                                            data-toggle="list" href="#list-stripe" role="tab">
                                            Stripe Payment
                                        </a>
                                        <a class="list-group-item list-group-item-action list-view {{session()->has('payment_settings_view_list') && session()->get('payment_settings_view_list') == 'razorpay-settings' ? 'active' : ''}}" 
                                            data-id="razorpay-settings" 
                                            id="list-razorpay-list"
                                            data-toggle="list" href="#list-razorpay" role="tab">
                                            Razorpay Payment
                                        </a>
                                        <a class="list-group-item list-group-item-action list-view {{session()->has('payment_settings_view_list') && session()->get('payment_settings_view_list') == 'cod-settings' ? 'active' : ''}}"  
                                            data-id="cod-settings" 
                                            id="list-cod-list"
                                            data-toggle="list" href="#list-cod" role="tab">
                                            COD Payment
                                        </a>

                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">

                                        <div class="tab-pane fade {{session()->has('payment_settings_view_list') && session()->get('payment_settings_view_list') == 'paypal-settings' ? 'show active' : ''}} 
                                            {{!session()->has('payment_settings_view_list') ? 'show active' : '' }}"  
                                            id="list-paypal" role="tabpanel"
                                            aria-labelledby="list-paypal-list">
                                            @include('admin.payment-setting.includes.paypal-setting')
                                        </div>


                                        <div class="tab-pane fade {{session()->has('payment_settings_view_list') && session()->get('payment_settings_view_list') == 'stripe-settings' ? 'show active' : ''}}" 
                                            id="list-stripe" role="tabpanel"
                                            aria-labelledby="list-stripe-list">
                                            @include('admin.payment-setting.includes.stripe-setting')
                                        </div>

                                        <div class="tab-pane fade {{session()->has('payment_settings_view_list') && session()->get('payment_settings_view_list') == 'razorpay-settings' ? 'show active' : ''}}" 
                                            id="list-razorpay" role="tabpanel"
                                            aria-labelledby="list-razorpay-list">
                                            @include('admin.payment-setting.includes.razorpay-setting')
                                        </div>
                                        <div class="tab-pane fade {{session()->has('payment_settings_view_list') && session()->get('payment_settings_view_list') == 'cod-settings' ? 'show active' : ''}}" 
                                            id="list-cod" role="tabpanel"
                                            aria-labelledby="list-cod-list">
                                            @include('admin.payment-setting.includes.cod-setting')
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
          $(document).ready(function(){

              $('.list-view').on('click', function(){

                  let style = $(this).data('id');
                  
                  $.ajax({
                      method: 'GET',
                      url: '{{route("admin.payment.view-list")}}',
                      data: {
                          style: style,
                      },
                      success: function(data){

                      }
                  });
              });

          });
    </script> 
@endpush
