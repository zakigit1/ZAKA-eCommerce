<section id="wsus__flash_sell" class="wsus__flash_sell_2">
    <div class=" container">
        <div class="row">
            <div class="col-xl-12">
                <div class="offer_time" style="background: url({{ asset('frontend/assets/images/flash_sell_bg.jpg') }})">
                    <div class="wsus__flash_coundown">
                        <span class=" end_text">flash sale</span>
                        <div class="simply-countdown simply-countdown-one"></div>
                        <a class="common_btn" href="{{ route('flash-sale.index') }}">see more <i
                                class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flash_sell_slider">

                    @php
                        $products = \App\Models\Product::withAvg('reviews','rating')
                        ->withCount('reviews')
                        ->with([
                            'gallery',
                            'category', 
                            'variants' => function ($query) {
                                $query->with([
                                        'items' => function ($q) {
                                            $q->where('status', 1);
                                        },
                                    ])
                                    ->where('status', 1);
                            },
                            'reviews' => function ($query) {
                                // get just reviews active
                                $query->where('status', 1);
                            }])
                        ->whereIn('id',$flashSaleItemProductId)->get();
                    @endphp

            @if (isset($products) && count($products) > 0)
                @foreach ($products as $product)

                    <div class="col-xl-3 col-sm-6 col-lg-4">
                        <div class="wsus__product_item">
                            <span class="wsus__new">{{ productType($product->product_type) }}</span>

                            @if (check_discount($product))
                                <span
                                    class="wsus__minus">-{{ calculate_discount_percentage($product->price, $product->offer_price) }}%</span>
                            @endif

                            <a class="wsus__pro_link" href="{{ route('product-details', $product->slug) }}">
                                <img src="{{ $product->thumb_image }}" alt="product" class="img-fluid w-100 img_1" />

                                @if (isset($product->gallery) && count($product->gallery) > 0)
                                    <img src="{{ $product->gallery[0]->image }}" alt="product"
                                        class="img-fluid w-100 img_2" />
                                @endif

                            </a>
                            <ul class="wsus__single_pro_icon">
                                <li>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="show_product_model" data-id="{{$product->id}}">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li><a href="" class="add_to_wishlist" data-id="{{ $product->id }}">
                                    <i class="far fa-heart"></i>
                                    </a>
                                </li>
                                
                            </ul>
                            <div class="wsus__product_details">
                                <a class="wsus__category" href="#">{{ $product->category->name }} </a>
                                <p class="wsus__pro_rating">
                                    {{-- @php
                                        $avgRating = $product->reviews()->avg('rating'); // calculate the avg reviews rating
                                        $fullRating = round($avgRating); // we convert to integer num
                                    @endphp --}}

                                    @for ($i = 1; $i <= 5; $i++)
                                        {{-- @if ($i <= $fullRating) --}}
                                        @if ($i <= $product->reviews_avg_rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor

                                    {{-- <span>({{ count($product->reviews) }} review)</span> --}}
                                    <span>({{ $product->reviews_count }} review)</span>
                                </p>
                                <a class="wsus__pro_name"
                                    href="{{ route('product-details', $product->slug) }}">{{ limitText($product->name, 53) }}</a>
                                <!-- Start check if there is discount or not -->
                                @if (check_discount($product))
                                    <p class="wsus__price">{{ $settings->currency_icon }} {{ $product->offer_price }}
                                        <del>{{ $settings->currency_icon }} {{ $product->price }}</del></p>
                                @else
                                    <p class="wsus__price">{{ $settings->currency_icon }} {{ $product->price }}</p>
                                @endif
                                <!-- End check if there is discount or not -->

                                <form class="shopping-cart-form">

                                    <input type="hidden" name="product_id" value="{{ $product->id }}">


                                    @foreach ($product->variants as $variant)
                                        <select class="d-none" name="variant_items[]">
                                            @foreach ($variant->items as $item)
                                                <option {{ $item->is_default == 1 ? 'selected' : '' }}
                                                    value="{{ $item->id }}"> {{ $item->name }}
                                                    {{ $item->price > 0 ? '(' . $settings->currency_icon . ' ' . $item->price . ')' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endforeach



                                    <input type="hidden" min="1" max="100" value="1" name="qty" />


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
</section>





@push('scripts')
    <script>
        // Count Down of Flash Sale
        simplyCountdown('.simply-countdown-one', {
            year: {{ date('Y', strtotime($flashSale->end_date)) }},
            month: {{ date('m', strtotime($flashSale->end_date)) }},
            day: {{ date('d', strtotime($flashSale->end_date)) }},
        });
    </script>
@endpush
