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
                                <a class="list-group-item list-group-item-action list-view {{session()->has('home_page_settings_view_list') && session()->get('home_page_settings_view_list') == 'popular-categories' ? 'active' : ''}} 
                                    {{!session()->has('home_page_settings_view_list') ? 'active' : '' }}"
                                   data-id="popular-categories" id="list-home-list" data-toggle="list" href="#list-home" role="tab">Popular Categories Settings</a>
                                
                                
                                <a class="list-group-item list-group-item-action list-view {{session()->has('home_page_settings_view_list') && session()->get('home_page_settings_view_list') == 'product-slider-one' ? 'active' : ''}} " 
                                  data-id="product-slider-one"  id="list-profile-list" data-toggle="list" href="#list-profile" role="tab">Product Slider Section One</a>
                                
                                
                                <a class="list-group-item list-group-item-action list-view {{session()->has('home_page_settings_view_list') && session()->get('home_page_settings_view_list') == 'product-slider-two' ? 'active' : ''}} " 
                                  data-id="product-slider-two"  id="list-messages-list" data-toggle="list" href="#list-messages" role="tab">Product Slider Section Two</a>
                                
                                
                                <a class="list-group-item list-group-item-action list-view {{session()->has('home_page_settings_view_list') && session()->get('home_page_settings_view_list') == 'weekly-best-products' ? 'active' : ''}} " 
                                  data-id="weekly-best-products"  id="list-settings-list" data-toggle="list" href="#list-settings" role="tab">Weekly Best Products</a>
                              </div>
                            </div>

                            <div class="col-10">
                              <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade {{session()->has('home_page_settings_view_list') && session()->get('home_page_settings_view_list') == 'popular-categories' ? 'show active' : ''}} 
                                {{!session()->has('home_page_settings_view_list') ? 'show active' : '' }}" 
                                  id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                  @include('admin.home-page-setting.sections.popular-categories')
                                </div>
                                      
                                      
                                <div class="tab-pane fade {{session()->has('home_page_settings_view_list') && session()->get('home_page_settings_view_list') == 'product-slider-one' ? 'show active' : ''}}" 
                                  id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                  @include('admin.home-page-setting.sections.product-slider-section-one')
                                </div>


                                <div class="tab-pane fade {{session()->has('home_page_settings_view_list') && session()->get('home_page_settings_view_list') == 'product-slider-two' ? 'show active' : ''}}" 
                                  id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                                  @include('admin.home-page-setting.sections.product-slider-section-two')
                                </div>
                                
                                <div class="tab-pane fade {{session()->has('home_page_settings_view_list') && session()->get('home_page_settings_view_list') == 'weekly-best-products' ? 'show active' : ''}}" 
                                  id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                                  @include('admin.home-page-setting.sections.weekly-best-products')
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
                    url: '{{route("admin.home-page-setting.view-list")}}',
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