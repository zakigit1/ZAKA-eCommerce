
@extends('Frontend.store.layouts.master')

@section('title', @$settings->site_name ." Vendors")

@section('content')



    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Vendors</h4>
                        <ul>
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><a href="javascript:;">Vendors</a></li>
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
      VENDORS START
    ==============================-->
    <section id="wsus__product_page" class="wsus__vendors">
        <div class="container">
            <div class="row">
   
                <div class="">
                    <div class="row">
                        @if(isset($vendors) && count($vendors)>0)
                            @foreach ($vendors as $vendor)   
                                <div class="col-xl-6 col-md-6">{{-- if you want to modify the size of the squares xl-* --}}
                                    <div class="wsus__vendor_single">
                                        <img src="{{$vendor->banner}}" alt="vendor" class="img-fluid w-100">
                                        <div class="wsus__vendor_text">
                                            <div class="wsus__vendor_text_center">
                                                <h4>{{$vendor->shop_name}}</h4>


                                                    {{-- i not sure about it codeium give it to me  --}}
                                                    <p class="wsus__vendor_rating">
                                                        @php
                                                            $totalRating = 0;
                                                            $totalReviews = 0;
                                                            if(isset($vendor->products) && count($vendor->products)>0){
                                                                foreach ($vendor->products as $product) {
                                                                    if(isset($product->reviews) && count( $product->reviews)>0){
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
                                                <a href="javascript:;"><i class="far fa-phone-alt"></i>
                                                    {{$vendor->phone}}</a>
                                                <a href="javascript:;"><i class="fal fa-envelope"></i>
                                                    {{$vendor->email}}</a>
                                                <a href="{{route('vendor.products',$vendor->id)}}" class="common_btn">visit store</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>


                <div class="col-xl-12">
                    <section id="pagination">
                        <nav aria-label="Page navigation example">
                            <div class="mt-5">
                                @if ($vendors->hasPages())
                                    {{ $vendors->withQueryString()->links() }}
                                @endif
                            </div>
                        </nav>
                    </section>
                </div>



                {{-- <div class="col-xl-12">
                    <section id="pagination">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link page_active" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </section>
                </div> --}}
            </div>
        </div>
    </section>
    <!--============================
       VENDORS END
    ==============================-->
@endsection