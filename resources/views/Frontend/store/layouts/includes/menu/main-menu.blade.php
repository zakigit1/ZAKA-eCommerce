<?php 
    $categories = App\Models\Category::active()
    ->with(['subcategories'=>function($query){
            $query->where('status',1)
            ->with(['childcategories'=>function($q){
                $q->where('status',1);
            }]);
        }])
    ->get(['id','name','slug']);
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
                    
                    @if(isset($categories) && count($categories) > 0 )
                        <ul class="wsus_menu_cat_item show_home toggle_menu">                                
                            @foreach($categories as $category)
                                <li><a class="{{(count($category->subcategories) > 0) ? 'wsus__droap_arrow' : ''}}" href="{{route('products.index',['category' => $category->slug])}}"><i class="{{$category->icon}}"></i> {{$category->name}} </a>
                                    
                                    {{-- Start Sub Category --}}
                                    @if(isset($category->subcategories) && count($category->subcategories) > 0)
                                            <ul class="wsus_menu_cat_droapdown">
                                                @foreach($category->subcategories as $subcategory)
                                                    {{-- @if( $subcategory->status !== 0 ) <!-- to display just the active subcategories --> --}}

                                                    <li><a href="{{route('products.index',['sub_category' => $subcategory->slug])}}">{{$subcategory->name}} <i class="{{(count($subcategory->childcategories) > 0) ? 'fas fa-angle-right' : ''}}"></i> </a>

                                                        {{-- Start Child Category --}}
                                                        @if(isset($subcategory->childcategories) && count($subcategory->childcategories) > 0 )
                                                            <ul class="wsus__sub_category">
                                                                @foreach($subcategory->childcategories as $childcategory)
                                                                    {{-- @if( $childcategory->status !== 0 )<!-- to display just the active subcategories --> --}}
                                                                        <li><a href="{{route('products.index',['child_category' => $childcategory->slug])}}">{{$childcategory->name}}</a> </li>
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
                        <li><a class="active" href="{{route('home')}}">home</a></li>
                        <li><a href="{{route('vendor.index')}}">Vendor</a></li>
                        <li><a href="{{route('blog')}}">Blog</a></li>
                        {{-- <li><a href="product_grid_view.html">shop <i class="fas fa-caret-down"></i></a>
                            <div class="wsus__mega_menu">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="wsus__mega_menu_colum">
                                            <h4>women</h4>
                                            <ul class="wsis__mega_menu_item">
                                                <li><a href="#">New Arrivals</a></li>
                                                <li><a href="#">Best Sellers</a></li>
                                                <li><a href="#">Trending</a></li>
                                                <li><a href="#">Clothing</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">Bags</a></li>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Jewlery & Watches</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="wsus__mega_menu_colum">
                                            <h4>men</h4>
                                            <ul class="wsis__mega_menu_item">
                                                <li><a href="#">New Arrivals</a></li>
                                                <li><a href="#">Best Sellers</a></li>
                                                <li><a href="#">Trending</a></li>
                                                <li><a href="#">Clothing</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">Bags</a></li>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Jewlery & Watches</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="wsus__mega_menu_colum">
                                            <h4>category</h4>
                                            <ul class="wsis__mega_menu_item">
                                                <li><a href="#"> Healthy & Beauty</a></li>
                                                <li><a href="#">Gift Ideas</a></li>
                                                <li><a href="#">Toy & Games</a></li>
                                                <li><a href="#">Cooking</a></li>
                                                <li><a href="#">Smart Phones</a></li>
                                                <li><a href="#">Cameras & Photo</a></li>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">View All Categories</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="wsus__mega_menu_colum">
                                            <h4>women</h4>
                                            <ul class="wsis__mega_menu_item">
                                                <li><a href="#">New Arrivals</a></li>
                                                <li><a href="#">Best Sellers</a></li>
                                                <li><a href="#">Trending</a></li>
                                                <li><a href="#">Clothing</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">Bags</a></li>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Jewlery & Watches</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> --}}
                        {{-- <li><a href="daily_deals.html">campain</a></li> --}}
                        {{-- <li class="wsus__relative_li"><a href="#">pages <i class="fas fa-caret-down"></i></a>
                            <ul class="wsus__menu_droapdown">
                                <li><a href="404.html">404</a></li>
                                <li><a href="faqs.html">faq</a></li>
                                <li><a href="invoice.html">invoice</a></li>
                                <li><a href="about_us.html">about</a></li>
                                <li><a href="product_grid_view.html">product</a></li>
                                <li><a href="check_out.html">check out</a></li>
                                <li><a href="team.html">team</a></li>
                                <li><a href="change_password.html">change password</a></li>
                                <li><a href="custom_page.html">custom page</a></li>
                                <li><a href="forget_password.html">forget password</a></li>
                                <li><a href="privacy_policy.html">privacy policy</a></li>
                                <li><a href="product_category.html">product category</a></li>
                                <li><a href="brands.html">brands</a></li>
                            </ul>
                        </li> --}}
                        @auth
                            <li><a href="{{route('user.track-order.index')}}">Track Order</a></li>
                        @endauth
                        <li><a href="{{route('flash-sale.index')}}">Flash Sale</a></li>
                        {{-- <li><a href="daily_deals.html">daily deals</a></li> --}}
                    </ul>
                    <ul class="wsus__menu_item wsus__menu_item_right">
                        <li><a href="{{route('contact.index')}}">Contact</a></li>

                        @if (Route::has('login'))
                            @auth
                                <li><a href="{{route(auth()->user()->role.'.dashboard')}}">My Account</a></li>
                                
                            @else
                                {{-- <li><a href="{{route('login')}}">Login</a></li> --}}
                                @if (Route::has('register'))
                                    <li><a href="{{route('register')}}">Register</a></li>
                                @endif
                            @endauth    

                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>  




