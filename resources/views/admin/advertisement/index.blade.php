@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Advertisements" }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>

            <h1>Manage Advertisements</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Advertisements</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">

                    <div class="card">
                        <div class="card-header">
                            <h4>Advertisements</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'banner-one' ? 'active' : '' }} 
                                    {{ !session()->has('banners_view_list') ? 'active' : '' }}"
                                            data-id="banner-one" id="list-home-list" data-toggle="list" href="#list-home"
                                            role="tab">Homepage Banner Section One</a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'banner-two' ? 'active' : '' }}"
                                            data-id="banner-two" id="list-profile-list" data-toggle="list"
                                            href="#list-profile" role="tab">Homepage Banner Section Two</a>


                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'banner-three' ? 'active' : '' }}"
                                            data-id="banner-three" id="list-messages-list" data-toggle="list"
                                            href="#list-messages" role="tab">Homepage Banner Section Three</a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'banner-four' ? 'active' : '' }}"
                                            data-id="banner-four" id="list-settings-list" data-toggle="list"
                                            href="#list-settings" role="tab">Homepage Banner Section Four</a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'product-banner' ? 'active' : '' }}"
                                            data-id="product-banner" id="list-products-list" data-toggle="list"
                                            href="#list-products" role="tab">Productpage Banner </a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'cart-banner' ? 'active' : '' }}"
                                            data-id="cart-banner" id="list-carts-list" data-toggle="list" href="#list-carts"
                                            role="tab">Cartpage Banner </a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'flash-sale-end-date-banner' ? 'active' : '' }}"
                                            data-id="flash-sale-end-date-banner" id="list-FSED-list" data-toggle="list"
                                            href="#list-FSED" role="tab">Homepage Banner Flash Sale End Date </a>

                                        <a class="list-group-item list-group-item-action list-view {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'flash-sale-see-more-banner' ? 'active' : '' }}"
                                            data-id="flash-sale-see-more-banner" id="list-FSSM-list" data-toggle="list"
                                            href="#list-FSSM" role="tab">Flash Sale See More Banner </a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">

                                        <div class="tab-pane fade {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'banner-one' ? 'show active' : '' }} 
                                            {{ !session()->has('banners_view_list') ? 'show active' : '' }}"
                                            id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                            @include('admin.advertisement.includes.homepage-banner-section-one')
                                        </div>


                                        <div class="tab-pane fade {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'banner-two' ? 'show active' : '' }}"
                                            id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                            @include('admin.advertisement.includes.homepage-banner-section-two')
                                        </div>


                                        <div class="tab-pane fade {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'banner-three' ? 'show active' : '' }}"
                                            id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                                            @include('admin.advertisement.includes.homepage-banner-section-three')
                                        </div>

                                        <div class="tab-pane fade {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'banner-four' ? 'show active' : '' }}"
                                            id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                                            @include('admin.advertisement.includes.homepage-banner-section-four')
                                        </div>

                                        <div class="tab-pane fade {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'product-banner' ? 'show active' : '' }}"
                                            id="list-products" role="tabpanel" aria-labelledby="list-products-list">
                                            @include('admin.advertisement.includes.productpage-banner')
                                        </div>

                                        <div class="tab-pane fade {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'cart-banner' ? 'show active' : '' }}"
                                            id="list-carts" role="tabpanel" aria-labelledby="list-carts-list">
                                            @include('admin.advertisement.includes.cartpage-banner')
                                        </div>

                                        <div class="tab-pane fade {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'flash-sale-end-date-banner' ? 'show active' : '' }}"
                                            id="list-FSED" role="tabpanel" aria-labelledby="list-FSED-list">
                                            @include('admin.advertisement.includes.homepage-banner-flash-sale-end-date')
                                        </div>

                                        <div class="tab-pane fade {{ session()->has('banners_view_list') && session()->get('banners_view_list') == 'flash-sale-see-more-banner' ? 'show active' : '' }}"
                                            id="list-FSSM" role="tabpanel" aria-labelledby="list-FSSM-list">
                                            @include('admin.advertisement.includes.flash-sale-see-more-banner')
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
                    url: '{{ route('admin.advertisement.view-list') }}',
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
