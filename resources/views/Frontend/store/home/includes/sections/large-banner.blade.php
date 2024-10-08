

<section id="wsus__large_banner">
    <div class="container">
        <div class="row text-center">
            <div class="cl-xl-12">
                <div class="wsus__large_banner_content">
                    @if ($homepageBannerSectionFour->status == 1)
                        <a href="{{$homepageBannerSectionFour->banner_url}}">
                            <img src="{{asset($homepageBannerSectionFour->banner_image)}}" alt="banner" class="img-fluid w-100">
                        </a>
                    @endif
                </div>


                {{-- <div class="wsus__large_banner_content" style="background: url({{asset($homepageBannerSectionFour->banner_image)}});">
                    <div class="wsus__large_banner_content_overlay">
                        <div class="row">
                            <div class="col-xl-6 col-12 col-md-6">
                                <div class="wsus__large_banner_text">

                                    <a class="shop_btn" href="{{$homepageBannerSectionFour->banner_url}}">view more</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-12 col-md-6">
                                <div class="wsus__large_banner_text wsus__large_banner_text_right">
                                    <h3>headphones</h3>
                                    <h5>up to 20% off</h5>
                                    <p>Spring's collection has discounted now!</p>
                                    <a class="shop_btn" href="#">shop now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</section>