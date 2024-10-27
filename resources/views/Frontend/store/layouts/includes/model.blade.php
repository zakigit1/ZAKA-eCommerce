


                
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
                                            <img src="{{ $product->thumb_image }}" alt="{{ $product->name }}"
                                                class="img-fluid w-100">
                                        </div>
                                    </div>
                                    {{-- 
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
                                    @endif --}}

                                </div>
                            </div>
                        </div>


                        <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">

                            <div class="wsus__pro_details_text">
                                <a class="title" href="{{ route('product-details', $product->slug)}}">{{ $product->name }}</a>

                                <!-- in stock / out of stock :     -->

                                @if ($product->qty > 0)
                                    <p class="wsus__stock_area"><span class="in_stock">in stock</span>
                                        ({{ $product->qty }} item)</p>
                                @else
                                    <p class="wsus__stock_area"><span class="in_stock">out of stock</span>
                                        ({{ $product->qty }} item)</p>
                                @endif

                                <!-- check discount and display price or offer_price if there discount:     -->
                                @if (check_discount($product))
                                    <h4>{{ $settings->currency_icon }} {{ $product->offer_price }}
                                        <del>{{ $settings->currency_icon }} {{ $product->price }}</del></h4>
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
                                        
                                        <li><a href="javascript:;" class="buy_now add_to_wishlist"
                                                data-id="{{ $product->id }}"><i
                                                    class="fal fa-heart"></i></a></li>
                                        
                                    </ul>
                                </form>

                                <p class="brand_model"><span>model :</span> {{ $product->sku }}</p>
                                <p class="brand_model"><span>brand :</span> {{ $product->brand->name }}</p>

                                {{-- <div class="wsus__pro_det_share">
                                    <h5>share :</h5>
                                    <ul class="d-flex">
                                        <li><a class="facebook" href="#"><i
                                                    class="fab fa-facebook-f"></i></a></li>
                                        <li><a class="twitter" href="#"><i
                                                    class="fab fa-twitter"></i></a></li>
                                        <li><a class="whatsapp" href="#"><i
                                                    class="fab fa-whatsapp"></i></a></li>
                                        <li><a class="instagram" href="#"><i
                                                    class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                