{{-- <div class="col-xl-3 col-sm-6 col-lg-4 {{@$key}}"> --}}
@php
    if (auth()->check()) {
        $wishlist_product_exists = App\Models\Wishlist::where('product_id', $product->id)
            ->where('user_id', auth()->user()->id)
            ->exists();
    } else {
        $wishlist_product_exists = false;
    }
@endphp

<div class="wsus__product_item {{ @$className }}">
    <span class="wsus__new">{{ productType($product->product_type) }}</span>

    @if (check_discount($product))
        <span class="wsus__minus">
            -{{ calculate_discount_percentage($product->price, $product->offer_price) }}%
        </span>
    @endif

    <a class="wsus__pro_link" href="{{ route('product-details', $product->slug) }}">
        <img src="{{ $product->thumb_image }}" alt="product" class="img-fluid w-100 img_1" />

        @if (isset($product->gallery) && count($product->gallery) > 0)
            <img src="{{ $product->gallery[0]->image }}" alt="product" class="img-fluid w-100 img_2" />
        @endif

    </a>
    @if (!@$className)
        <ul class="wsus__single_pro_icon">
            <li>
                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="show_product_model"
                    data-id="{{ $product->id }}">
                    <i class="far fa-eye"></i>
                </a>
            </li>
            <li class="wsus__single_pro_icon_heart"><a href="" class="add_to_wishlist"
                    data-id="{{ $product->id }}"
                    style="{{ $wishlist_product_exists
                        ? '
                            text-transform: uppercase;
                            font-size: 12px;
                            font-weight: 600;
                            color: #fff !important;
                            background: #B01E28;
                            
                            border-radius: 3px;
                            '
                        : '' }}">
                    <i class="{{ $wishlist_product_exists ? 'fas' : 'far' }} fa-heart"
                        id="wishlist-heart-{{ $wishlistSection == null ? '0' : $wishlistSection }}-{{ $product->id }}"></i>
                </a>
            </li>

        </ul>
    @endif
    <div class="wsus__product_details">
        <a class="wsus__category" href="#">{{ $product->category->name }} </a>
        <p class="wsus__pro_rating">
            {{-- @php
                    $avgRating = $product->reviews()->avg('rating'); // calculate the avg reviews rating
                    $fullRating = round($avgRating); // we convert to integer num
                @endphp --}}

            @for ($i = 1; $i <= 5; $i++)
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
                <del>{{ $settings->currency_icon }} {{ $product->price }}</del>
            </p>
        @else
            <p class="wsus__price">{{ $settings->currency_icon }} {{ $product->price }}</p>
        @endif
        <!-- End check if there is discount or not -->


        @if (@$className)
            <p class="list_description">{{ $product->short_description }}</p>

            <ul class="wsus__single_pro_icon">

                <li style="margin-right: 10px">
        @endif
        <form class="shopping-cart-form">

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            @if (isset($product->variants) && count($product->variants) > 0)
                @foreach ($product->variants as $variant)
                    <select class="d-none" name="variant_items[]">
                        @if (isset($variant->items) && count($variant->items) > 0)
                            @foreach ($variant->items as $item)
                                <option {{ $item->is_default == 1 ? 'selected' : '' }} value="{{ $item->id }}">
                                    {{ $item->name }}
                                    {{ $item->price > 0 ? '(' . $settings->currency_icon . ' ' . $item->price . ')' : '' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                @endforeach
            @endif



            <input type="hidden" min="1" max="100" value="1" name="qty" />


            <button type="submit" class="add_cart" href="#">
                add to cart
            </button>

        </form>
        @if (@$className)
            </li>

            <li class="wsus__single_pro_icon_heart">
                <a href="" class="add_to_wishlist" data-id="{{ $product->id }}"
                    style="{{ $wishlist_product_exists
                        ? '
                                                text-transform: uppercase;
                                                font-size: 12px;
                                                font-weight: 600;
                                                color: #fff !important;
                                                background: #B01E28;
                                                border-radius: 3px;
                                                '
                        : '' }}">
                    <i class="{{ $wishlist_product_exists ? 'fas' : 'far' }} fa-heart"
                        id="wishlist-heart-1-{{ $product->id }}"></i>
                </a>
            </li>
            </ul>
        @endif
    </div>
</div>
{{-- </div> --}}
