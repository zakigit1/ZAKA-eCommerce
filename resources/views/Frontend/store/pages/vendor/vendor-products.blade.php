@extends('Frontend.store.layouts.master')

@section('title', @$settings->site_name . ' Vendor Products')

@section('content')

    <!--============================
                    BREADCRUMB START
                    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Products</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('vendor.index') }}">Vendors</a></li>
                            <li><a href="javascript:;">Vendor Product</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                        BREADCRUMB END
                    ==============================-->


    <!--============================
                        PRODUCT PAGE START
                    ==============================-->
    <section id="wsus__product_page">
        <div class="container">
            <div class="row">

                {{-- banner --}}
                <div class="col-xl-12">
                    <div class="wsus__pro_page_bammer vendor_det_banner">
                        <img src="{{ $vendor->banner }}" alt="banner" class="img-fluid w-100" style="height: 350px">
                        <div class="wsus__pro_page_bammer_text wsus__vendor_det_banner_text">
                            <div class="wsus__vendor_text_center">
                                <h4>{{ $vendor->shop_name }}</h4>
                                {{-- i not sure about it codeium give it to me  --}}
                                <p class="wsus__vendor_rating">
                                    @php
                                        $totalRating = 0;
                                        $totalReviews = 0;
                                        if (isset($vendor->products) && count($vendor->products) > 0) {
                                            foreach ($vendor->products as $product) {
                                                if (isset($product->reviews) && count($product->reviews) > 0) {
                                                    $avgProductRating = $product->reviews()->avg('rating');
                                                    $totalRating += $avgProductRating * $product->reviews()->count();
                                                    $totalReviews += $product->reviews()->count();
                                                }
                                            }
                                        }
                                        $avgVendorRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;
                                        $fullRating = round($avgVendorRating); // we convert to integer num
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $fullRating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor

                                </p>
                                <a href="javascript:;"><i class="far fa-phone-alt"></i> {{ $vendor->phone }}</a>
                                <a href="javascript:;"><i class="far fa-envelope"></i> {{ $vendor->email }}</a>
                                <p class="wsus__vendor_location"><i class="fal fa-map-marker-alt"></i>{{ $vendor->address }}
                                </p>
                                <p class="wsus__open_store"><i class="fab fa-shopify"></i> store open</p>
                                <ul class="d-flex">
                                    <li><a class="facebook" href="{{ $vendor->fb_link }}"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                    <li><a class="instagram" href="{{ $vendor->insta_link }}"><i
                                                class="fab fa-instagram"></i></a></li>
                                    <li><a class="twitter" href="{{ $vendor->tw_link }}"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    {{-- <li><a class="whatsapp" href="#"><i class="fab fa-whatsapp"></i></a></li> --}}
                                </ul>
                                {{-- <a class="common_btn" href="#" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class="fas fa-star"></i>add review</a> --}}
                            </div>
                        </div>
                    </div>
                </div>


                {{-- main products --}}
                <div class="">
                    <div class="row">
                        <div class="col-xl-12 d-none d-md-block mt-md-4 mt-lg-0">
                            <div class="wsus__product_topbar">
                                <div class="wsus__product_topbar_left">

                                    <div class="nav nav-pills " id="v-pills-tab" role="tablist" aria-orientation="vertical">

                                        <button
                                            class="nav-link list-view {{ session()->has('product_list_view_style') && session()->get('product_list_view_style') == 'grid' ? 'active' : '' }} 
                                            {{ !session()->has('product_list_view_style') ? 'active' : '' }}"
                                            data-id="grid" id="v-pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-home" type="button" role="tab"
                                            aria-controls="v-pills-home" aria-selected="true">
                                            <i class="fas fa-th"></i>
                                        </button>

                                        <button
                                            class="nav-link list-view {{ session()->has('product_list_view_style') && session()->get('product_list_view_style') == 'list' ? 'active' : '' }} "
                                            data-id="list" id="v-pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-profile" type="button" role="tab"
                                            aria-controls="v-pills-profile" aria-selected="false">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                    </div>


                                </div>


                            </div>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade {{ session()->has('product_list_view_style') && session()->get('product_list_view_style') == 'grid' ? 'show active' : '' }} 
                                {{ !session()->has('product_list_view_style') ? 'show active' : '' }}"
                                id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="row">

                                    {{-- show 12 products --}}
                                    @if (isset($products) && count($products) > 0)
                                        @foreach ($products as $product)
                                            <div class="col-xl-3  col-sm-6">
                                                <div class="wsus__product_item">
                                                    <span
                                                        class="wsus__new">{{ productType($product->product_type) }}</span>

                                                    @if (check_discount($product))
                                                        <span
                                                            class="wsus__minus">-{{ calculate_discount_percentage($product->price, $product->offer_price) }}%</span>
                                                    @endif

                                                    <a class="wsus__pro_link"
                                                        href="{{ route('product-details', $product->slug) }}">
                                                        <img src="{{ $product->thumb_image }}" alt="product"
                                                            class="img-fluid w-100 img_1" />

                                                        @if (isset($product->gallery) && count($product->gallery) > 0)
                                                            <img src="{{ $product->gallery[0]->image }}" alt="product"
                                                                class="img-fluid w-100 img_2" />
                                                        @endif

                                                    </a>
                                                    <ul class="wsus__single_pro_icon">
                                                        <li><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal-{{ $product->id }}"><i
                                                                    class="far fa-eye"></i></a></li>
                                                        <li><a href="" class="add_to_wishlist"
                                                                data-id="{{ $product->id }}"><i
                                                                    class="far fa-heart"></i></a></li>

                                                    </ul>
                                                    <div class="wsus__product_details">
                                                        <a class="wsus__category"
                                                            href="#">{{ $product->category->name }}</a>
                                                        <p class="wsus__pro_rating">
                                                            @php

                                                                $avgRating = $product->reviews()->avg('rating'); // calculate the avg reviews rating
                                                                $fullRating = round($avgRating); // we convert to integer num
                                                            @endphp

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $fullRating)
                                                                    <i class="fas fa-star"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor

                                                            <span>({{ count($product->reviews) }} review)</span>
                                                        </p>

                                                        <a class="wsus__pro_name"
                                                            href="{{ route('product-details', $product->slug) }}">{{ limitText($product->name, 53) }}</a>

                                                        <!-- Start check if there is discount or not -->
                                                        @if (check_discount($product))
                                                            <p class="wsus__price">{{ $settings->currency_icon }}
                                                                {{ $product->offer_price }}
                                                                <del>{{ $settings->currency_icon }}
                                                                    {{ $product->price }}</del>
                                                            </p>
                                                        @else
                                                            <p class="wsus__price">{{ $settings->currency_icon }}
                                                                {{ $product->price }}</p>
                                                        @endif
                                                        <!-- End check if there is discount or not -->

                                                        <form class="shopping-cart-form">

                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">

                                                            @if (isset($product->variants) && count($product->variants) > 0)
                                                                @foreach ($product->variants as $variant)
                                                                    <select class="d-none" name="variant_items[]">
                                                                        @foreach ($variant->items as $item)
                                                                            <option
                                                                                {{ $item->is_default == 1 ? 'selected' : '' }}
                                                                                value="{{ $item->id }}">
                                                                                {{ $item->name }}
                                                                                {{ $item->price > 0 ? '(' . $settings->currency_icon . ' ' . $item->price . ')' : '' }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                @endforeach
                                                            @endif



                                                            <input type="hidden" min="1" max="100"
                                                                value="1" name="qty" />


                                                            <button type="submit" class="add_cart" href="#">
                                                                add to cart
                                                            </button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>

                            <div class="tab-pane fade {{ session()->has('product_list_view_style') && session()->get('product_list_view_style') == 'list' ? 'show active' : '' }} "
                                id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div class="row">

                                    {{-- show 6 products --}}
                                    @if (isset($products) && count($products) > 0)
                                        @foreach ($products as $product)
                                            <div class="col-xl-12">
                                                <div class="wsus__product_item wsus__list_view">

                                                    <span
                                                        class="wsus__new">{{ productType($product->product_type) }}</span>

                                                    @if (check_discount($product))
                                                        <span
                                                            class="wsus__minus">-{{ calculate_discount_percentage($product->price, $product->offer_price) }}%</span>
                                                    @endif



                                                    <a class="wsus__pro_link"
                                                        href="{{ route('product-details', $product->slug) }}">
                                                        <img src="{{ $product->thumb_image }}" alt="product"
                                                            class="img-fluid w-100 img_1" />

                                                        @if (isset($product->gallery) && count($product->gallery) > 0)
                                                            <img src="{{ $product->gallery[0]->image }}" alt="product"
                                                                class="img-fluid w-100 img_2" />
                                                        @endif
                                                    </a>

                                                    <div class="wsus__product_details">
                                                        <a class="wsus__category"
                                                            href="#">{{ $product->category->name }}</a>
                                                        <p class="wsus__pro_rating">
                                                            @php

                                                                $avgRating = $product->reviews()->avg('rating'); // calculate the avg reviews rating
                                                                $fullRating = round($avgRating); // we convert to integer num
                                                            @endphp

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $fullRating)
                                                                    <i class="fas fa-star"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor

                                                            <span>({{ count($product->reviews) }} review)</span>
                                                        </p>

                                                        <a class="wsus__pro_name"
                                                            href="{{ route('product-details', $product->slug) }}">{{ limitText($product->name, 53) }}</a>



                                                        <!-- Start check if there is discount or not -->
                                                        @if (check_discount($product))
                                                            <p class="wsus__price">{{ $settings->currency_icon }}
                                                                {{ $product->offer_price }}
                                                                <del>{{ $settings->currency_icon }}
                                                                    {{ $product->price }}</del>
                                                            </p>
                                                        @else
                                                            <p class="wsus__price">{{ $settings->currency_icon }}
                                                                {{ $product->price }}</p>
                                                        @endif
                                                        <!-- End check if there is discount or not -->


                                                        <p class="list_description">{{ $product->short_description }}</p>

                                                        <ul class="wsus__single_pro_icon">

                                                            <li style="margin-right: 10px">

                                                                <form class="shopping-cart-form">

                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product->id }}">


                                                                    @foreach ($product->variants as $variant)
                                                                        <select class="d-none" name="variant_items[]">
                                                                            @foreach ($variant->items as $item)
                                                                                <option
                                                                                    {{ $item->is_default == 1 ? 'selected' : '' }}
                                                                                    value="{{ $item->id }}">
                                                                                    {{ $item->name }}
                                                                                    {{ $item->price > 0 ? '(' . $settings->currency_icon . ' ' . $item->price . ')' : '' }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endforeach



                                                                    <input type="hidden" min="1" max="100"
                                                                        value="1" name="qty" />


                                                                    <button type="submit" class="add_cart"
                                                                        href="#">
                                                                        add to cart
                                                                    </button>


                                                                </form>
                                                            </li>

                                                            <li><a href="" class="add_to_wishlist"
                                                                    data-id="{{ $product->id }}"><i
                                                                        class="far fa-heart"></i></a></li>

                                                        </ul>




                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>


                        @if (count($products) == 0)
                            <div class="text-center mt-5">
                                <div class="card">
                                    <div class="card-body" style="background:#ebebf2">
                                        <h2>We Don't Have This Product Now ! Please Check Later</h2>
                                    </div>

                                </div>
                            </div>
                        @endif


                    </div>
                </div>


                {{-- pagination --}}


                <div class="col-xl-12">
                    <section id="pagination">
                        <nav aria-label="Page navigation example">
                            <div class="mt-5">
                                @if ($products->hasPages())
                                    {{ $products->withQueryString()->links() }}
                                @endif
                            </div>
                        </nav>
                    </section>
                </div>


            </div>
        </div>
    </section>
    <!--============================
                        PRODUCT PAGE END
                    ==============================-->

    <!--============================
                        PRODUCT Popup Model Start
                    ==============================-->


    @if (isset($products) && count($products) > 0)
        @foreach ($products as $product)
            <section class="product_popup_modal">
                <div class="modal fade" id="exampleModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                        class="far fa-times"></i></button>
                                <div class="row">

                                    <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                                        <div class="wsus__quick_view_img">
                                            <!-- Display product video  :     -->
                                            @if ($product->video_link)
                                                <a class="venobox wsus__pro_det_video" data-autoplay="true"
                                                    data-vbtype="video" href="{{ $product->video_link }}">
                                                    <i class="fas fa-play"></i>
                                                </a>
                                            @endif

                                            <!-- Display product Images (thumb_image + gallery ):     -->

                                            <div class="row modal_slider">

                                                <div class="col-xl-12">
                                                    <div class="modal_slider_img">
                                                        <img src="{{ $product->thumb_image }}"
                                                            alt="{{ $product->name }}" class="img-fluid w-100">
                                                    </div>
                                                </div>

                                                @if (isset($product->gallery) && count($product->gallery) > 0)
                                                    @foreach ($product->gallery as $image)
                                                        <div class="col-xl-12">
                                                            <div class="modal_slider_img">
                                                                <img src="{{ $image->image }}"
                                                                    alt="{{ $product->name }} gallery"
                                                                    class="img-fluid w-100">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- we have problem we need to show at leaste two imagess :     -->
                                                    <div class="col-xl-12">
                                                        <div class="modal_slider_img">
                                                            <img src="{{ $product->thumb_image }}"
                                                                alt="{{ $product->name }}" class="img-fluid w-100">
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">

                                        <div class="wsus__pro_details_text">
                                            <a class="title" href="#">{{ $product->name }}</a>

                                            <!-- in stock / out of stock :     -->

                                            @if ($product->qty > 0)
                                                <p class="wsus__stock_area"><span class="in_stock">in stock</span>
                                                    ({{ $product->qty }} item)
                                                </p>
                                            @else
                                                <p class="wsus__stock_area"><span class="in_stock">out of stock</span>
                                                    ({{ $product->qty }} item)</p>
                                            @endif

                                            <!-- check discount and display price or offer_price if there discount:     -->
                                            @if (check_discount($product))
                                                <h4>{{ $settings->currency_icon }} {{ $product->offer_price }}
                                                    <del>{{ $settings->currency_icon }} {{ $product->price }}</del>
                                                </h4>
                                            @else
                                                <h4>{{ $settings->currency_icon }} {{ $product->price }}</h4>
                                            @endif

                                            <!-- reviews :     -->
                                            <p class="review">
                                                @php

                                                    $avgRating = $product->reviews()->avg('rating'); // calculate the avg reviews rating
                                                    $fullRating = round($avgRating); // we convert to integer num
                                                @endphp

                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $fullRating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor

                                                <span>{{ count($product->reviews) }} review</span>
                                            </p>

                                            <!-- description :     -->
                                            <p class="description"> {!! $product->short_description !!} </p>

                                            <form class="shopping-cart-form">
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                                <div class="wsus__selectbox">
                                                    <div class="row">
                                                        @if (isset($product->variants) && count($product->variants) > 0)
                                                            @foreach ($product->variants as $variant)
                                                                <div class="col-xl-6 col-sm-6">
                                                                    <h5 class="mb-2">{{ $variant->name }}:</h5>

                                                                    @if (isset($variant->items) && count($variant->items) > 0)
                                                                        <select class="select_2" name="variant_items[]">
                                                                            @foreach ($variant->items as $item)
                                                                                <option
                                                                                    {{ $item->is_default ? 'selected' : '' }}
                                                                                    value="{{ $item->id }}">
                                                                                    {{ $item->name }}
                                                                                    {{ $item->price > 0 ? '(' . $settings->currency_icon . ' ' . $item->price . ')' : '' }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="wsus__quentity">
                                                    <h5>quentity :</h5>
                                                    <div class="select_number">
                                                        <input class="number_area" type="text" min="1"
                                                            max="100" value="1" name="qty" />
                                                    </div>

                                                </div>

                                                <ul class="wsus__button_area">
                                                    <li><button type="submit" class="add_cart" href="#">add to
                                                            cart</button></li>

                                                    <li><a href="" class="buy_now add_to_wishlist"
                                                            data-id="{{ $product->id }}"><i
                                                                class="fal fa-heart"></i></a>
                                                    </li>

                                                </ul>
                                            </form>

                                            <p class="brand_model"><span>model :</span> {{ $product->sku }}</p>
                                            @if (isset($product->brand->name))
                                                <p class="brand_model"><span>brand :</span> 
                                                    {{ $product->brand->name }}
                                                </p>
                                            @endif

                                            <div class="wsus__pro_det_share">
                                                <h5>share :</h5>
                                                <ul class="d-flex">
                                                    <li><a class="facebook" href="#"><i
                                                                class="fab fa-facebook-f"></i></a></li>
                                                    <li><a class="twitter" href="#"><i
                                                                class="fab fa-twitter"></i></a>
                                                    </li>
                                                    <li><a class="whatsapp" href="#"><i
                                                                class="fab fa-whatsapp"></i></a></li>
                                                    <li><a class="instagram" href="#"><i
                                                                class="fab fa-instagram"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif

    <!--============================
                        PRODUCT Popup Model End
                    ==============================-->

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.list-view').on('click', function() {

                let style = $(this).data('id');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('change-product-view-list') }}',
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
