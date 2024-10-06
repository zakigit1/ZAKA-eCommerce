<section id="wsus__single_banner" class="wsus__single_banner_2">
    <div class="container">
        <div class="row">

            <div class="col-xl-6 col-lg-6">
                <div class="wsus__single_banner_content">
                    <div class="wsus__single_banner_img">
                        
                        @if ($homepageBannerSectionTwo[2]->status == 1)
                            <a href="{{$homepageBannerSectionTwo[0]->banner_1->banner_url_1}}">
                                <img src="{{asset($homepageBannerSectionTwo[0]->banner_1->banner_image_1)}}" alt="banner" class="img-fluid w-100">
                            </a>
                        @endif

                    </div>

                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="wsus__single_banner_content single_banner_2">
                    <div class="wsus__single_banner_img">
                        @if ($homepageBannerSectionTwo[2]->status == 1)
                            <a href="{{$homepageBannerSectionTwo[1]->banner_2->banner_url_2}}">
                                <img src="{{asset($homepageBannerSectionTwo[1]->banner_2->banner_image_2)}}" alt="banner" class="img-fluid w-100">
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>