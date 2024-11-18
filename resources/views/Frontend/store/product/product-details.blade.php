@extends('Frontend.store.layouts.master')

@section('title', "$settings->site_name || Product Details")

@section('content')



    <!--============================
                                    BREADCRUMB START
                                ==============================-->


    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>products details</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">home</a></li>
                            <li><a href="#">product</a></li>
                            <li><a href="javascript:;">product details</a></li>
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
                                    PRODUCT DETAILS START
                                ==============================-->


    <section id="wsus__product_details">
        <div class="container">
            <div class="wsus__details_bg">
                <div class="row">
                    <div class="col-xl-4 col-md-5 col-lg-5" style="z-index:999">
                        <div id="sticky_pro_zoom">
                            <div class="exzoom hidden" id="exzoom">
                                <div class="exzoom_img_box">
                                    @if ($product->video_link)
                                        <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                            href="{{ $product->video_link }}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    <ul class='exzoom_img_ul'>
                                        <li><img class="zoom ing-fluid w-100" src="{{ $product->thumb_image }}"
                                                alt="product"></li>
                                        @if (isset($product->gallery) && count($product->gallery) > 0)
                                            @foreach ($product->gallery as $image)
                                                <li><img class="zoom ing-fluid w-100" src="{{ $image->image }}"
                                                        alt="product"></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="exzoom_nav"></div>
                                <p class="exzoom_btn">
                                    <a href="javascript:void(0);" class="exzoom_prev_btn"> <i
                                            class="far fa-chevron-left"></i> </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> <i
                                            class="far fa-chevron-right"></i> </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-md-7 col-lg-7">
                        <div class="wsus__pro_details_text">
                            <a class="title" href="javascript:;">{{ $product->name }}</a>
                            @if ($product->qty > 0)
                                <p class="wsus__stock_area"><span class="in_stock">in stock</span> ({{ $product->qty }}
                                    item)</p>
                            @else
                                <p class="wsus__stock_area"><span class="in_stock">out of stock</span> ({{ $product->qty }}
                                    item)</p>
                            @endif


                            <!-- Start check if there is discount we show offer price if not we show price  -->
                            @if (check_discount($product))
                                <h4>{{ $settings->currency_icon }} {{ $product->offer_price }}
                                    <del>{{ $settings->currency_icon }} {{ $product->price }}</del>
                                </h4>
                            @else
                                <h4>{{ $settings->currency_icon }} {{ $product->price }}</h4>
                            @endif
                            <!-- End check if there is discount or not -->


                            <p class="review">

                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $product->reviews_avg_rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor

                                <span>{{ $product->reviews_count }} review</span>
                            </p>


                            <p class="description">
                                {!! $product->short_description !!}
                            </p>

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
                                                                <option {{ $item->is_default ? 'selected' : '' }}
                                                                    value="{{ $item->id }}"> {{ $item->name }}
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
                                        <input class="number_area" type="text" min="1" max="100"
                                            value="1" name="qty" />
                                    </div>

                                </div>

                                <ul class="wsus__button_area">
                                    <li><button type="submit" class="add_cart" href="#">add to cart</button></li>

                                    {{-- this is for heart icon of wishlist if you want to add it : style="border:1px solid gray; padding:7px 11px;border-radius:100%" --}}
                                    <li><a href="javascript:;" class="buy_now  add_to_wishlist"
                                            data-id="{{ $product->id }}">
                                            <i class="fal fa-heart"></i></a>
                                    </li>
                                    @if (auth()->check())
                                        <li>
                                            <button type="button" class="chat_now" style="margin-left: 10px"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="fas fa-comment-medical"></i>
                                            </button>
                                        </li>
                                    @else
                                        {{-- after remove it make it just just when auth show the icon of messaging --}}

                                        <li>
                                            <button type="button" class="chat_now" style="margin-left: 10px"
                                                data-bs-toggle="modal" data-bs-target="false">
                                                <i class="fas fa-comment-slash"></i>
                                            </button>
                                        </li>
                                    @endif

                                </ul>
                            </form>


                            <p class="brand_model"><span>model :</span> {{ $product->sku }}</p>
                            <p class="brand_model"><span>brand :</span> {{ $product->brand->name }}</p>

                            <div class="wsus__pro_det_share">
                                <h5>share :</h5>
                                <ul class="d-flex">
                                    <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a class="whatsapp" href="#"><i class="fab fa-whatsapp"></i></a></li>
                                    <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>

                            <a class="wsus__pro_report" href="#" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"><i class="fal fa-comment-alt-smile"></i> Report incorrect
                                product information.</a>
                        </div>
                    </div>


                    {{-- <div class="col-xl-3 col-md-12 mt-md-5 mt-lg-0">
                                            <div class="wsus_pro_det_sidebar" id="sticky_sidebar">
                                                <ul>
                                                    <li>
                                                        <span><i class="fal fa-truck"></i></span>
                                                        <div class="text">
                                                            <h4>Return Available</h4>
                                                            <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span><i class="far fa-shield-check"></i></span>
                                                        <div class="text">
                                                            <h4>Secure Payment</h4>
                                                            <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span><i class="fal fa-envelope-open-dollar"></i></span>
                                                        <div class="text">
                                                            <h4>Warranty Available</h4>
                                                            <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="wsus__det_sidebar_banner">
                                                    <img src="{{ asset('frontend/assets/images/blog_1.jpg') }}" alt="banner"
                                                        class="img-fluid w-100">
                                                    <div class="wsus__det_sidebar_banner_text_overlay">
                                                        <div class="wsus__det_sidebar_banner_text">
                                                            <p>Black Friday Sale</p>
                                                            <h4>Up To 70% Off</h4>
                                                            <a href="#" class="common_btn">shope now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_det_description">
                        <div class="wsus__details_bg">
                            <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab7" data-bs-toggle="pill"
                                        data-bs-target="#pills-home22" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">Description</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Vendor Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab2" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact2" type="button" role="tab"
                                        aria-controls="pills-contact2" aria-selected="false">Reviews</button>
                                </li>

                            </ul>

                            <div class="tab-content" id="pills-tabContent4">
                                <div class="tab-pane fade  show active " id="pills-home22" role="tabpanel"
                                    aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">

                                                {!! $product->long_description !!}

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <div class="wsus__pro_det_vendor">
                                        <div class="row">
                                            <div class="col-xl-6 col-xxl-5 col-md-6">
                                                <div class="wsus__vebdor_img">
                                                    <img src="{{ $product->vendor->banner }}" alt="vensor"
                                                        class="img-fluid w-100">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-xxl-7 col-md-6 mt-4 mt-md-0">
                                                <div class="wsus__pro_det_vendor_text">
                                                    <h4>{{ $product->vendor->user->name }}</h4>
                                                    <p class="rating">

                                                        {{-- i not sure about it codeium give it to me  --}}
                                                        @php
                                                            $totalRating = 0;
                                                            $totalReviews = 0;
                                                            if (
                                                                isset($product->vendor->products) &&
                                                                count($product->vendor->products) > 0
                                                            ) {
                                                                foreach ($product->vendor->products as $product) {
                                                                    if (
                                                                        isset($product->reviews) &&
                                                                        count($product->reviews) > 0
                                                                    ) {
                                                                        $avgProductRating = $product
                                                                            ->reviews()
                                                                            ->avg('rating');
                                                                        $totalRating +=
                                                                            $avgProductRating *
                                                                            $product->reviews()->count();
                                                                        $totalReviews += $product->reviews()->count();
                                                                    }
                                                                }
                                                            }
                                                            $avgVendorRating =
                                                                $totalReviews > 0 ? $totalRating / $totalReviews : 0;
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
                                                    <p><span>Store Name:</span> {{ $product->vendor->shop_name }}</p>
                                                    <p><span>Address:</span> {{ $product->vendor->address }}</p>
                                                    <p><span>Phone:</span> {{ $product->vendor->phone }}</p>
                                                    <p><span>mail:</span> {{ $product->vendor->email }}</p>
                                                    <a href="javascript:;" class="see_btn">visit store</a>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="wsus__vendor_details">
                                                    <p>{!! $product->vendor->description !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact2" role="tabpanel"
                                    aria-labelledby="pills-contact-tab2">
                                    <div class="wsus__pro_det_review">
                                        <div class="wsus__pro_det_review_single">
                                            <div class="row">

                                                <div class="col-xl-8 col-lg-7">

                                                    <div class="wsus__comment_area">
                                                        <h4>Reviews <span>{{ count($reviews) }}</span></h4>
                                                        @if (isset($reviews) && count($reviews) > 0)
                                                            @foreach ($reviews as $review)
                                                                <div class="wsus__main_comment">
                                                                    <div class="wsus__comment_img">
                                                                        <img src="{{ $review->user->image }}"
                                                                            alt="user" class="img-fluid w-100">
                                                                    </div>
                                                                    <div class="wsus__comment_text reply">
                                                                        <h6>{{ $review->user->name }}<span>{{ $review->rating }}
                                                                                <i class="fas fa-star"></i></span></h6>
                                                                        <span>{{ date('Y M d', strtotime($review->created_at)) }}</span>
                                                                        <p>{{ $review->review != null ? $review->review : '' }}
                                                                        </p>
                                                                        @if (isset($review->productReviewGalleries) && count($review->productReviewGalleries) > 0)
                                                                            <ul class="">
                                                                                @foreach ($review->productReviewGalleries as $productReviewImage)
                                                                                    <li><img src="{{ $productReviewImage->image }}"
                                                                                            alt="product"
                                                                                            class="img-fluid w-100"></li>
                                                                                @endforeach

                                                                            </ul>
                                                                        @endif
                                                                        {{-- this for replay of review from another users  --}}

                                                                        {{-- <a href="#" data-bs-toggle="collapse"
                                                                                                data-bs-target="#flush-collapsetwo">
                                                                                                reply
                                                                                            </a> 
                                                                                            <div class="accordion accordion-flush"
                                                                                                id="accordionFlushExample2">
                                                                                                <div class="accordion-item">
                                                                                                    <div id="flush-collapsetwo"
                                                                                                        class="accordion-collapse collapse"
                                                                                                        aria-labelledby="flush-collapsetwo"
                                                                                                        data-bs-parent="#accordionFlushExample">
                                                                                                        <div class="accordion-body">
                                                                                                            <form>
                                                                                                                <div
                                                                                                                    class="wsus__riv_edit_single text_area">
                                                                                                                    <i class="far fa-edit"></i>
                                                                                                                    <textarea cols="3" rows="1" placeholder="Your Text"></textarea>
                                                                                                                </div>
                                                                                                                <button type="submit"
                                                                                                                    class="common_btn">submit</button>
                                                                                                            </form>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div> --}}

                                                                    </div>
                                                                </div>
                                                            @endforeach


                                                            {{-- Pagination of reviews --}}
                                                            <div class="col-xl-12">
                                                                <section id="pagination">
                                                                    <nav aria-label="Page navigation example">
                                                                        <div class="mt-5">
                                                                            @if ($reviews->hasPages())
                                                                                {{ $reviews->withQueryString()->links() }}
                                                                            @endif
                                                                        </div>
                                                                    </nav>
                                                                </section>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{--  Review Form  --}}
                                                {{-- First for doing rating or review first the user need to be authanticated --}}
                                                @auth
                                                    @php
                                                        // ? After we check if the user has already order the product and delivered to him , after he can rate the product
                                                        $orders = \App\Models\Order::with('orderProducts')
                                                            ->where([
                                                                'user_id' => auth()->user()->id,
                                                                'order_status' => 'delivered',
                                                            ])
                                                            ->get();

                                                        // dd($orders);
                                                        $isBought = false;
                                                        if (isset($orders) && count($orders) > 0) {
                                                            foreach ($orders as $key => $order) {
                                                                $productExist = $order->orderProducts
                                                                    ->where('product_id', $product->id)
                                                                    ->first();
                                                            }

                                                            if ($productExist) {
                                                                $isBought = true;
                                                            }
                                                        }

                                                    @endphp


                                                    @if ($isBought)
                                                        {{-- mean $isBought == true  --}}
                                                        <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">
                                                            <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                                <h4>write a Review</h4>
                                                                <form action="{{ route('user.product-review.create') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf

                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product->id }}">

                                                                    <input type="hidden" name="vendor_id"
                                                                        value="{{ $product->vendor_id }}">


                                                                    <p class="rating">
                                                                        <span>select your rating : </span>
                                                                        {{-- <i class="fas fa-star"></i> --}}
                                                                    </p>

                                                                    <div class="row">
                                                                        <div class="col-xl-12 mb-4">
                                                                            <div class="wsus__single_com">

                                                                                <select class="form-control" name="rating">

                                                                                    <option disabled selected value="">
                                                                                        Select</option>
                                                                                    <option class="fas fa-star"
                                                                                        value="1">1 </option>
                                                                                    <option class="fas fa-star"
                                                                                        value="2">2 </option>
                                                                                    <option class="fas fa-star"
                                                                                        value="3">3 </option>
                                                                                    <option class="fas fa-star"
                                                                                        value="4">4 </option>
                                                                                    <option class="fas fa-star"
                                                                                        value="5">5 </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-xl-12">
                                                                            <div class="col-xl-12">
                                                                                <div class="wsus__single_com">
                                                                                    <textarea cols="3" rows="3" name="review" placeholder="Write your review"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="img_upload">
                                                                        <div class="gallery">
                                                                            <label>Share Images :</label><br><br>
                                                                            <input type="file" class='form-control'
                                                                                name="images[]" multiple id="">
                                                                        </div>
                                                                    </div>

                                                                    <button class="common_btn" type="submit">submit
                                                                        review</button>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Modal -->
    <div div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contact The {{ $product->vendor->shop_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  method="post" class="message_model">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $product->vendor->user_id }}">

                        <div class="form-group">
                            <label for=""><b>Message :</b></label><br>
                            <textarea name="message" class="form-control mt-2 message-box" placeholder="Enter Your Message"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary send-message-button">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <!--============================
                                    PRODUCT DETAILS END
                                ==============================-->


    <!--============================
                                    RELATED PRODUCT START
                                ==============================-->

    {{-- <section id="wsus__flash_sell">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header">
                        <h3>Related Products</h3>
                        <a class="see_btn" href="#">see more <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row flash_sell_slider">
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__new">New</span>
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="product_details.html">
                            <img src="images/pro3.jpg" alt="product" class="img-fluid w-100 img_1" />
                            <img src="images/pro3_3.jpg" alt="product" class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">Electronics </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(133 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">hp 24" FHD monitore</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__new">New</span>
                        <a class="wsus__pro_link" href="product_details.html">
                            <img src="images/pro4.jpg" alt="product" class="img-fluid w-100 img_1" />
                            <img src="images/pro4_4.jpg" alt="product" class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">fashion </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(17 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">men's casual fashion watch</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="product_details.html">
                            <img src="images/pro9.jpg" alt="product" class="img-fluid w-100 img_1" />
                            <img src="images/pro9_9.jpg" alt="product" class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">fashion </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(120 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">men's fashion sholder bag</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__new">New</span>
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="product_details.html">
                            <img src="images/pro2.jpg" alt="product" class="img-fluid w-100 img_1" />
                            <img src="images/pro2_2.jpg" alt="product" class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">fashion </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(72 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">men's casual shoes</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="product_details.html">
                            <img src="images/pro4.jpg" alt="product" class="img-fluid w-100 img_1" />
                            <img src="images/pro4_4.jpg" alt="product" class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">fashion </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(17 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">men's casual fashion watch</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}

    <!--============================
                                    RELATED PRODUCT END
                                ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.message_model').on('submit', function(e) {
                e.preventDefault();

                
                let data = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "{{ route('user.send-message-to-vendor') }}",
                    data: data,
                    beforeSend: function() {
                      let  html = `<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true">
                            </span> Sending...`
                       $('.send-message-button').html(html);
                       $('.send-message-button').prop('disabled', true);
                    },
                    success: function(response) {

                        if (response.status == 'success') {
                            $('.message-box').val('');
                            toastr.success(response.message);
                            // $('#exampleModal').modal('hide');// if you want to hide the model after sending the message ...
                        }else if (response.status == 'error') {
                            toastr.error(response.message);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        toastr.error(xhr.responseJSON.message);  
                        $('.send-message-button').html('send message');
                        $('.send-message-button').prop('disabled', false);  
                    },
                    complete: function() {
                        $('.send-message-button').html('send message');
                        $('.send-message-button').prop('disabled', false);
                        
                    }
                });
            })
        });
    </script>
@endpush
