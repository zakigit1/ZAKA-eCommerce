@extends('Frontend.store.layouts.master')

@section('content')


    <!--==========================
      PRODUCT MODAL VIEW START
    ===========================-->
    @include('Frontend.store.home.includes.sections.product-model-view')
    
    <!--==========================
      PRODUCT MODAL VIEW END
    ===========================-->


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

    @include('Frontend.store.home.includes.sections.flash-sell')
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
    {{-- @include('Frontend.store.home.includes.sections.brand-slider') --}}
    <!--============================
        BRAND SLIDER END
    ==============================-->


    <!--============================
        SINGLE BANNER START
    ==============================-->
    {{-- @include('Frontend.store.home.includes.sections.single-banner') --}}
    <!--============================
        SINGLE BANNER END  
    ==============================-->


    <!--============================
        HOT DEALS START
    ==============================-->
    {{-- @include('Frontend.store.home.includes.sections.hot-deals') --}}
    <!--============================
        HOT DEALS END  
    ==============================-->


    <!--============================
        ELECTRONIC PART START  (category 1 )
    ==============================-->
    {{-- @include('Frontend.store.home.includes.sections.category-one') --}}
    <!--============================
        ELECTRONIC PART END  
    ==============================-->


    <!--============================
        ELECTRONIC PART START   (category 2 )
    ==============================-->
    {{-- @include('Frontend.store.home.includes.sections.category-two') --}}
    <!--============================
        ELECTRONIC PART END  
    ==============================-->


    <!--============================
        LARGE BANNER  START  
    ==============================-->
    {{-- @include('Frontend.store.home.includes.sections.large-banner') --}}
    <!--============================
        LARGE BANNER  END  
    ==============================-->


    <!--============================
        WEEKLY BEST ITEM START  
    ==============================-->

    {{-- @include('Frontend.store.home.includes.sections.weekly-best-item') --}}
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