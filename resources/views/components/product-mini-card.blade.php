<a class="wsus__hot_deals__single" href="{{route('product-details',$item->slug)}}">
    <div class="wsus__hot_deals__single_img">
        <img src="{{$item->thumb_image}}" alt="bag" class="img-fluid w-100">
    </div>
    <div class="wsus__hot_deals__single_text mt-2">
        <h5 title="{{$item->name}}">{{limitText($item->name,53)}}</h5>
        <p class="wsus__rating">
                @for($i = 1 ; $i <= 5 ;$i++)
                    @if( $i <= $item->reviews_avg_rating)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
        </p>

        <!-- Start check if there is discount we show offer price if not we show price  -->
        @if (check_discount($item))
            <p class="wsus_tk">{{ $settings->currency_icon }} {{ $item->offer_price }}
                <del style="color: red">{{ $settings->currency_icon }} {{ $item->price }}</del>
            </p>
        @else
            <p class="wsus_tk">{{ $settings->currency_icon }} {{ $item->price }}</p>
        @endif
        <!-- End check if there is discount or not -->
    </div>
</a>