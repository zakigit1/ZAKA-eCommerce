
@php
    // Footer DATA : 
    $footerInfo = \App\Models\FooterInfo::first();

    $footerSocials = \App\Models\FooterSocial::where('status', 1)->get();

    $footerGridTwoLinks= \App\Models\FooterGridTwo::where('status', 1)->get();
    
    $footerTitle= \App\Models\FooterTitle::first();
    
    $footerGridThreeLinks= \App\Models\FooterGridThree::where('status', 1)->get();


@endphp





<footer class="footer_2">
    <div class="container">
        <div class="row justify-content-between">

            {{-- Footer Information (Grid one) --}}
            <div class="col-xl-3 col-sm-7 col-md-6 col-lg-3">
                <div class="wsus__footer_content">

                    @if (isset($footerInfo))
                        <a class="wsus__footer_2_logo" href="#">
                            <img src="{{@$footerInfo->logo}}" alt="logo">
                        </a>
                        <a class="action" href="callto:{{@$footerInfo->phone}}"><i class="fas fa-phone-alt"></i>
                            {{@$footerInfo->phone}}</a>
                        <a class="action" href="mailto:{{@$footerInfo->email}}"><i class="far fa-envelope"></i>
                            {{@$footerInfo->email}}</a>
                        <p><i class="fal fa-map-marker-alt"></i> {{@$footerInfo->address}}</p>
                    @endif

                    <ul class="wsus__footer_social">
                        @if(isset($footerSocials) && count($footerSocials) > 0)
                            @foreach ($footerSocials as $social)
                                <li><a class="{{$social->name}}" href="{{$social->url}}"><i class="{{$social->icon}}"></i></a></li>
                            @endforeach
                        @endif

                    </ul>

                </div>


            </div>


            {{-- Footer Grid two --}}
            <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                <div class="wsus__footer_content">
                    <h5>{{$footerTitle->footer_grid_two_title}}</h5>
                    <ul class="wsus__footer_menu">
                        @foreach ($footerGridTwoLinks as $footerGridTwoLink)
                            <li><a href="{{$footerGridTwoLink->url}}"><i class="fas fa-caret-right"></i> {{$footerGridTwoLink->name}}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
            {{-- Footer Grid three --}}
            <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                <div class="wsus__footer_content">
                    <h5>{{$footerTitle->footer_grid_three_title}}</h5>
                    <ul class="wsus__footer_menu">
                        @foreach ($footerGridThreeLinks as $footerGridThreeLink)
                            <li><a href="{{$footerGridThreeLink->url}}"><i class="fas fa-caret-right"></i> {{$footerGridThreeLink->name}}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>

            {{-- footer newsletter (grid four) --}}
            <div class="col-xl-4 col-sm-7 col-md-8 col-lg-5">
                <div class="wsus__footer_content wsus__footer_content_2">
                    <h3>Subscribe To Our Newsletter</h3>
                    <p>Get all the latest information on Events, Sales and Offers.
                        Get all the latest information on Events.</p>
                    <form  method="POST" id="newsletter">
                        @csrf

                        <input class="newsletter_email" type="text" name="email" placeholder="Enter Your Email">
                        <button type="submit" class="common_btn subscribe_btn">Subscribe</button>

                    </form>
                    <div class="footer_payment">
                        <p>We're using safe payment for :</p>
                        <img src="{{asset('frontend/assets/images/credit2.png')}}" alt="card" class="img-fluid">
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Copyright --}}
    <div class="wsus__footer_bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__copyright d-flex justify-content-center">
                        <p>{{@$footerInfo->copyright}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>