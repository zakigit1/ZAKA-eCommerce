@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Admin Payment Settings  "}}
@endsection

@section('content')


    <section class="section">
        <div class="section-header">
        <h1>Manage Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
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
                                <a class="list-group-item list-group-item-action active" id="list-paypal-list" data-toggle="list" href="#list-home" role="tab">Paypal Payment</a>
                                <a class="list-group-item list-group-item-action" id="list-stripe-list" data-toggle="list" href="#list-profile" role="tab">Stripe Payment</a>

                              </div>
                            </div>
                            <div class="col-10">
                              <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-paypal-list">
                                      @include('admin.payment-setting.includes.paypal-setting')
                                </div>
                                      
                                      
                                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-stripe-list">
                                        
                                      @include('admin.payment-setting.includes.stripe-setting')
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


