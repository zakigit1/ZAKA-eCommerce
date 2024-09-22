@php
    $products = [] ;
@endphp


<section id="wsus__monthly_top" class="wsus__monthly_top_2">
    <div class="container">
        <!-- Black Friday Sale -->

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="wsus__monthly_top_banner">
                    <div class="wsus__monthly_top_banner_img">
                        <img src="{{asset('frontend/assets/images/monthly_top_img3.jpg')}}" alt="img" class="img-fluid w-100">
                        <span></span>
                    </div>
                    <div class="wsus__monthly_top_banner_text">
                        <h4>Black Friday Sale</h4>
                        <h3>Up To <span>70% Off</span></h3>
                        <H6>Everything</H6>
                        <a class="shop_btn" href="#">shop now</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories Of The Month -->

        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header for_md">
                    <h3>Top Categories Of The Month</h3>
                    <div class="monthly_top_filter">
                        {{-- <button class=" active" data-filter="*">ALL</button> --}}

                        @foreach ($popularCategories as $popularCategory)
                        
                            @php

                                $lastkey = [];
                                foreach ($popularCategory as $categoryType => $value){ //category type mean : sub_category or child_category

                                    if($value === null){
                                        break;
                                    }

                                    $lastkey = [$categoryType => $value];

                                }

                                // dd($lastkey);

                                if(array_keys($lastkey)[0] == 'category'){
                                    $cat_type = \App\Models\Category::find($lastkey['category']);
                                    $products [] =\App\Models\Product::where('category_id',$cat_type->id)->orderBy('id','DESC')->take(12)->get();
                                }elseif (array_keys($lastkey)[0] == 'sub_category') {
                                    $cat_type = \App\Models\Subcategory::find($lastkey['sub_category']);
                                    $products [] =\App\Models\Product::where('sub_category_id',$cat_type->id)->orderBy('id','DESC')->take(12)->get();
                                }elseif(array_keys($lastkey)[0] == 'child_category') {
                                    $cat_type = \App\Models\Childcategory::find($lastkey['child_category']);
                                    $products [] =\App\Models\Product::where('child_category_id',$cat_type->id)->orderBy('id','DESC')->take(12)->get();
                                }
     
                            @endphp

                            <button class="{{$loop->index == 0 ? 'auto_click active' : '' }}" data-filter=".category-{{$loop->index}}">{{$cat_type->name}}</button>

                        @endforeach


                        {{-- <button data-filter=".elec">Electronic</button>
                        <button data-filter=".spk">Speakers</button>
                        <button data-filter=".cam">Cameras</button>
                        <button data-filter=".wat">Watches</button> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!-- products loop -->
                <div class="row grid">
                    @foreach ($products as $key => $product)
                        @foreach ($product as $item)

                            {{-- {{dd($item);}} --}}
                            <div class="col-xl-2 col-6 col-sm-6 col-md-4 col-lg-3  category-{{$key}}">
                                <a class="wsus__hot_deals__single" href="{{route('product-details',$item->slug)}}">
                                    <div class="wsus__hot_deals__single_img">
                                        <img src="{{$item->thumb_image}}" alt="bag" class="img-fluid w-100">
                                    </div>
                                    <div class="wsus__hot_deals__single_text">
                                        <h5>{{limitText($item->name)}}</h5>
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
                        @endforeach
                    @endforeach





                </div>

            </div>
        </div>
    </div>
</section>