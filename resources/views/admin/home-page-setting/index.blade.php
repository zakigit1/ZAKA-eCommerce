@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Admin Settings  "}}
@endsection

@section('content')


    <section class="section">
        <div class="section-header">
        <h1>Manage Home Page Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item">Home Page Setting</div>
        </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                
                    <div class="card">
                        <div class="card-header">
                          <h4>Home Page Settings</h4>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-2">
                              <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab">Popular Categories Settings</a>
                                <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab">Product Slider Section One</a>
                                <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab">Product Slider Section Two</a>
                                <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab">Settings</a>
                              </div>
                            </div>
                            <div class="col-10">
                              <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                        @include('admin.home-page-setting.sections.popular-categories')
                                      </div>
                                      
                                      
                                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                  @include('admin.home-page-setting.sections.product-slider-section-one')
                                </div>


                                <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                                  @include('admin.home-page-setting.sections.product-slider-section-two')
                                </div>

                                <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                                  Lorem ipsum culpa in ad velit dolore anim labore incididunt do aliqua sit veniam commodo elit dolore do labore occaecat laborum sed quis proident fugiat sunt pariatur. Cupidatat ut fugiat anim ut dolore excepteur ut voluptate dolore excepteur mollit commodo. 
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