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

                    <x-product-card :product="$product" />

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
