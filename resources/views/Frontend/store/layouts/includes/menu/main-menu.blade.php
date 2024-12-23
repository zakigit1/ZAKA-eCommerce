<?php
$categories = App\Models\Category::active()
    ->with([
        'subcategories' => function ($query) {
            $query->where('status', 1)->with([
                'childcategories' => function ($q) {
                    $q->where('status', 1);
                },
            ]);
        },
    ])
    ->get(['id', 'name', 'slug']);
?>


<nav class="wsus__main_menu d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="relative_contect d-flex">
                    <div class="wsus_menu_category_bar">
                        <i class="far fa-bars"></i>
                    </div>

                    {{-- Start Main Category --}}

                    @if (isset($categories) && count($categories) > 0)
                        <ul class="wsus_menu_cat_item show_home toggle_menu">
                            @foreach ($categories as $category)
                                <li><a class="{{ count($category->subcategories) > 0 ? 'wsus__droap_arrow' : '' }}"
                                        href="{{ route('products.index', ['category' => $category->slug]) }}"><i
                                            class="{{ $category->icon }}"></i> {{ $category->name }} </a>

                                    {{-- Start Sub Category --}}
                                    @if (isset($category->subcategories) && count($category->subcategories) > 0)
                                        <ul class="wsus_menu_cat_droapdown">
                                            @foreach ($category->subcategories as $subcategory)
                                                {{-- @if ($subcategory->status !== 0) <!-- to display just the active subcategories --> --}}

                                                <li><a
                                                        href="{{ route('products.index', ['sub_category' => $subcategory->slug]) }}">{{ $subcategory->name }}
                                                        <i
                                                            class="{{ count($subcategory->childcategories) > 0 ? 'fas fa-angle-right' : '' }}"></i>
                                                    </a>

                                                    {{-- Start Child Category --}}
                                                    @if (isset($subcategory->childcategories) && count($subcategory->childcategories) > 0)
                                                        <ul class="wsus__sub_category">
                                                            @foreach ($subcategory->childcategories as $childcategory)
                                                                {{-- @if ($childcategory->status !== 0)<!-- to display just the active subcategories --> --}}
                                                                <li><a
                                                                        href="{{ route('products.index', ['child_category' => $childcategory->slug]) }}">{{ $childcategory->name }}</a>
                                                                </li>
                                                                {{-- @endif --}}
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    {{-- End Child Category --}}

                                                </li>
                                                {{-- @endif --}}
                                            @endforeach
                                        </ul>
                                    @endif
                                    {{-- End Sub Category --}}
                                </li>
                            @endforeach
                            <li><a href="#"><i class="fal fa-gem"></i> View All Categories</a></li>
                        </ul>
                    @endif
                    {{-- End Main Category --}}


                    <ul class="wsus__menu_item">
                        <li><a class="{{ setActive(['home']) }}" href="{{ route('home') }}">home</a></li>
                        <li><a class="{{ setActive(['vendor.index']) }}" href="{{ route('vendor.index') }}">Vendor</a>
                        </li>
                        <li><a class="{{ setActive(['blog']) }}" href="{{ route('blog') }}">Blog</a></li>
                        @auth
                            <li><a class="{{ setActive(['user.track-order.index']) }}"
                                    href="{{ route('user.track-order.index') }}">Track Order</a></li>
                        @endauth
                        <li><a class="{{ setActive(['flash-sale.index']) }}"
                                href="{{ route('flash-sale.index') }}">Flash Sale</a></li>

                        {{-- <li><a href="daily_deals.html">daily deals</a></li> --}}
                    </ul>

                    <ul class="wsus__menu_item wsus__menu_item_right">
                        <li><a class="{{ setActive(['contact.index']) }}"
                                href="{{ route('contact.index') }}">Contact</a></li>

                        {{-- @if (Route::has('login')) --}}

                        @auth
                            {{-- it mean (admin.dashboard Or user.dashboard Or vendor.dashboard) --}}
                            {{-- <li><a href="{{route(auth()->user()->role.'.dashboard')}}">My Account</a></li> --}}
                            <li><a href="{{ route('user.dashboard') }}">My Account</a></li>
                        @else
                            {{-- <li><a href="{{route('login')}}">Login</a></li> --}}
                            @if (Route::has('register'))
                                {{-- Make dropdown
                                <li class="wsus__relative_li">
                                    <a href="{{route('register')}}">
                                        Sign in 
                                        <i class="fas fa-caret-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="wsus__menu_droapdown" style="width: 150px">
                                        <li><a href="{{route('register')}}">Register</a></li>
                                    </ul>
                                </li> --}}
                                <li><a href="{{route('register')}}">Sign in</a></li>
                            @endif
                        @endauth

                    </ul>
                </div>
            </div>
        </div>
    </div>



</nav>
