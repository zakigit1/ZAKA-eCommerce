@extends('Frontend.store.layouts.master')

@section('title', @$settings->site_name ." || e-Commerce ")

@section('content')


    <!--============================
        BANNER PART 2 START
    ==============================-->

    @include('Frontend.store.home.includes.sections.banner')

    <!--============================
        BANNER PART 2 END
    ==============================-->


    <!--============================
        FLASH SELL START
    ==============================-->

    @include('Frontend.store.home.includes.sections.flash-sale')

    <!--============================
        FLASH SELL END
    ==============================-->


    <!--============================
       MONTHLY TOP PRODUCT START (Top Categories Products)
    ==============================-->

    {{-- @include('Frontend.store.home.includes.sections.top-category-product') --}}

    <!--============================
       MONTHLY TOP PRODUCT END
    ==============================-->


    <!--============================
        BRAND SLIDER START
    ==============================-->

    @include('Frontend.store.home.includes.sections.brand-slider')

    <!--============================
        BRAND SLIDER END
    ==============================-->


    <!--============================
        SINGLE BANNER START
    ==============================-->

    @include('Frontend.store.home.includes.sections.single-banner')
    
    <!--============================
        SINGLE BANNER END  
    ==============================-->


    <!--============================
        HOT DEALS START
    ==============================-->

    @include('Frontend.store.home.includes.sections.hot-deals') 

    <!--============================
        HOT DEALS END  
    ==============================-->


    <!--============================
        ELECTRONIC PART START  (category 1 )
    ==============================-->

    @include('Frontend.store.home.includes.sections.category-one')
    
    <!--============================
        ELECTRONIC PART END  
    ==============================-->


    <!--============================
        ELECTRONIC PART START   (category 2 )
    ==============================-->

    @include('Frontend.store.home.includes.sections.category-two')

    <!--============================
        ELECTRONIC PART END  
    ==============================-->


    <!--============================
        LARGE BANNER  START  
    ==============================-->

    @include('Frontend.store.home.includes.sections.large-banner')
    
    <!--============================
        LARGE BANNER  END  
    ==============================-->


    <!--============================
        WEEKLY BEST ITEM START  
    ==============================-->

    @include('Frontend.store.home.includes.sections.weekly-best-item')

    <!--============================
        WEEKLY BEST ITEM END 
    ==============================-->


    <!--============================
      HOME SERVICES START
    ==============================-->

    {{-- @include('Frontend.store.home.includes.sections.home-service') --}}

    <!--============================
        HOME SERVICES END
    ==============================-->


    <!--============================
        HOME BLOGS START
    ==============================-->

    {{-- @include('Frontend.store.home.includes.sections.home-blog') --}}

    <!--============================
        HOME BLOGS END
    ==============================-->

@endsection

{{-- @push('scripts')
  
<script>
    $(document).ready(function() {

        // this is for crsf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.add_to_wishlist', function(e) {
            e.preventDefault();
            e.stopPropagation();

        var isAuthenticated = @auth true
                @else
                    false
                @endauth ;

        let productId = $(this).data('id');



        if (!isAuthenticated) {
            toastr.warning("You need to login to add this product to your wishlist");
            return;
        }

        $.ajax({
                url: "{{ route('user.wishlist.store') }}",
                method: 'GET',
                data: {
                    productId: productId
                },
                success: function(data) {
                    
                    if (data.status == 'success') {
                        $('#wishlist_count').text(data.count)

                            // wish list button design (style)
                            wishlistStylebutton(data)
                            toastr.success(data.message);
                        } else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        console.log('error');
                    }
                });
        });


        function wishlistStylebutton(data){

        // Update the heart icon based on the product's wishlist status
        const heartIcon = $(`#wishlist-heart-${data.productId}`); 
        const heartIcon2 = $(`#wishlist-heart2-${data.productId}`); 
        const parentLink = heartIcon.parent(); 

        if (data.style === 'fas') {
            // Product is not in the wishlist
            heartIcon.removeClass('fas').addClass('far'); // Change to empty heart
            heartIcon2.removeClass('fas').addClass('far'); // Change to empty heart
            // Remove styles from the parent <a> element
            heartIcon.parent().attr('style', ''); // Clear styles
            heartIcon2.parent().attr('style', ''); // Clear styles
        } else if (data.style === 'far') {
            // Product is in the wishlist
            heartIcon.removeClass('far').addClass('fas'); // Change to filled heart
            heartIcon2.removeClass('far').addClass('fas'); // Change to filled heart

            if (parentLink.hasClass('buy_now')) {

                heartIcon.parent().attr('style', `
                    text-transform: uppercase;
                    font-weight: 600;
                    color: #fff !important;
                    background: #B01E28;
                    padding: 9px 15px;
                    border-radius: 30px;
                    font-size: 14px;
                `);
            } else {
                heartIcon.parent().attr('style', `
                    text-transform: uppercase;
                    font-size: 12px;
                    font-weight: 600;
                    color: #fff !important;
                    background: #B01E28;
                    border-radius: 3px;
                `);
                heartIcon2.parent().attr('style', `
                    text-transform: uppercase;
                    font-size: 12px;
                    font-weight: 600;
                    color: #fff !important;
                    background: #B01E28;
                    border-radius: 3px;
                `);
            }
        }
        }

    });
</script>
@endpush --}}