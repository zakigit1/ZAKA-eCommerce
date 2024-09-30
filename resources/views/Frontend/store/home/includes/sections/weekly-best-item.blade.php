<section id="wsus__weekly_best" class="home2_wsus__weekly_best_2 ">
    <div class="container">
        <div class="row">

            @if(isset($weeklyBestProducts) && count($weeklyBestProducts) > 0)
                @foreach ($weeklyBestProducts as $key => $weeklyBestProduct)
                    @php
                            
                        $lastkey = [];
                        foreach ($weeklyBestProduct as $categoryType => $value) {
                            //category type mean : sub_category or child_category

                            if ($value === null) {
                                break;
                            }

                            $lastkey = [$categoryType => $value];
                        }

                        // dd($lastkey);

                        if (array_keys($lastkey)[0] == 'category') {
                            $cat_type = \App\Models\Category::find($lastkey['category']);
                            $products = \App\Models\Product::where('category_id', $cat_type->id)
                                ->orderBy('id', 'DESC')
                                ->take(12)
                                ->get();
                        } elseif (array_keys($lastkey)[0] == 'sub_category') {
                            $cat_type = \App\Models\Subcategory::find($lastkey['sub_category']);
                            $products = \App\Models\Product::where('sub_category_id', $cat_type->id)
                                ->orderBy('id', 'DESC')
                                ->take(12)
                                ->get();
                        } elseif (array_keys($lastkey)[0] == 'child_category') {
                            $cat_type = \App\Models\Childcategory::find($lastkey['child_category']);
                            $products = \App\Models\Product::where('child_category_id', $cat_type->id)
                                ->orderBy('id', 'DESC')
                                ->take(12)
                                ->get();
                        }

                    @endphp
                
            

                    <div class="col-xl-6 col-sm-6">
                        <div class="wsus__section_header">
                            <h3>{{($key == 0) ? 'Weekly Best Rated Products':'Weekly Best Sale Products'}}</h3>
                        </div>
                        <div class="row weekly_best2">
                    
                            @foreach ($products as $key => $item)
                                {{-- @foreach ($product as $item) --}}
                            
                                            <div class="col-xl-4 col-lg-4">
                                                <a class="wsus__hot_deals__single" href="{{route('product-details',$item->slug)}}">
                                                    <div class="wsus__hot_deals__single_img">
                                                        <img src="{{$item->thumb_image}}" alt="bag" class="img-fluid w-100">
                                                    </div>
                                                    <div class="wsus__hot_deals__single_text mt-2">
                                                        <h5>{{limitText($item->name,53)}}</h5>
                                                        <p class="wsus__rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star-half-alt"></i>
                                                        </p>

                                                        <!-- Start check if there is discount we show offer price if not we show price  -->
                                                        @if (check_discount($item))
                                                            <p class="wsus_tk">{{ $settings->currency_icon }} {{ $item->offer_price }}
                                                            <del>{{ $settings->currency_icon }} {{ $item->price }}</del></p>
                                                        @else
                                                            <p class="wsus_tk">{{ $settings->currency_icon }} {{ $item->price }}</p>
                                                        @endif
                                                        <!-- End check if there is discount or not -->
                                                    </div>
                                                </a>
                                            </div>
                                            
                                            
                                {{-- @endforeach --}}
                            @endforeach
                        </div>
                    </div>


                @endforeach
            @endif

        </div>
    </div>
</section>
