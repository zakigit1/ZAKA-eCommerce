<section id="wsus__banner">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__banner_content">
                    <!-- Dynamic Sliders -->
                    <div class="row banner_slider">

                        @if(isset($sliders) && count($sliders)>0)
                            @foreach($sliders as $slider)
                            <div class="col-xl-12">
                                <div class="wsus__single_slider" style="background: url({{$slider->banner}});">
                                    <div class="wsus__single_slider_text">
                                        <h3>{!! $slider->type !!}</h3>
                                        <h1>{!! $slider->title !!}</h1>
                                        <h6>start at {{$settings->currency_icon}} {{$slider->starting_price}}</h6>
                                        <a class="common_btn" href="{{$slider->btn_url}}">shop now</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif

                    </div>

                    <!-- Static Sliders -->
                    {{-- <div class="row banner_slider">
                        <div class="col-xl-12">
                            <div class="wsus__single_slider" style="background: url({{asset('frontend/assets/images/slider_1.jpg')}});">
                                <div class="wsus__single_slider_text">
                                    <h3>new arrivals</h3>
                                    <h1>men's fashion</h1>
                                    <h6>start at $99.00</h6>
                                    <a class="common_btn" href="#">shop now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__single_slider" style="background: url({{asset('frontend/assets/images/slider_2.jpg')}});">
                                <div class="wsus__single_slider_text">
                                    <h3>new arrivals</h3>
                                    <h1>kid's fashion</h1>
                                    <h6>start at $49.00</h6>
                                    <a class="common_btn" href="#">shop now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__single_slider" style="background: url({{asset('frontend/assets/images/slider_3.jpg')}});">
                                <div class="wsus__single_slider_text">
                                    <h3>new arrivals</h3>
                                    <h1>winter collection</h1>
                                    <h6>start at $99</h6>
                                    <a class="common_btn" href="#">shop now</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>