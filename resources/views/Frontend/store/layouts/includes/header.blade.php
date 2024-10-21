
<header>
    <div class="container">
        <div class="row">
            <div class="col-2 col-md-1 d-lg-none">
                <div class="wsus__mobile_menu_area">
                    <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
                </div>
            </div>
            <div class="col-xl-2 col-7 col-md-8 col-lg-2">
                <div class="wsus_logo_area">
                    <a class="wsus__header_logo" href="{{route('home')}}">
                        <img src="{{$logoSettings->logo}}" alt="logo" class="img-fluid w-100">
                    </a>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 col-lg-4 d-none d-lg-block">
                <div class="wsus__search">
                    <form action="{{route('products.index')}}" method="GET"> 
                        <input type="text" placeholder="Search..." name="search" value="{{request()->search}}">
                        <button type="submit"><i class="far fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="col-xl-5 col-3 col-md-3 col-lg-6">
                <div class="wsus__call_icon_area">
                    <div class="wsus__call_area">
                        <div class="wsus__call">
                            <i class="fas fa-user-headset"></i>
                        </div>
                        <div class="wsus__call_text">
                            <p>{{$settings->contact_email}}</p>
                            <p>+213 {{$settings->contact_phone}}</p>{{-- make a config file about +213 3la hasab country of admin--}}
                        </div>
                    </div>
                    <ul class="wsus__icon_area">
                        <li>
                            <a href="{{route('user.wishlist.index')}}"><i class="fal fa-heart"></i>
                                @auth()
                                <span id="wishlist_count">
                                    {{\App\Models\Wishlist::where('user_id' , auth()->user()->id)->count()}}    
                                </span>
                                @endauth
                            </a>
                        </li>
                        {{-- <li><a href="#"><i class="fal fa-random"></i><span>03</span></a></li> --}}
                        <li><a class="wsus__cart_icon" href="#">
                            {{-- <i class="fal fa-shopping-bag"></i><span>{{Cart::count();}}</span></a></li> --}}
                            <i class="fal fa-shopping-bag"></i><span id="cart-count">{{Cart::content()->count()}}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="wsus__mini_cart">
        <h4>shopping cart <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
        <ul class="mini-cart-wrapper">
            @if(count(Cart::content()) > 0)
                @foreach (Cart::content() as $cartProduct)        
                    <li id="mini_cart_{{$cartProduct->rowId}}">
                        <div class="wsus__cart_img">
                            <a href="{{route('product-details',$cartProduct->options->slug)}}"><img src="{{$cartProduct->options->image}}" alt="product" class="img-fluid w-100"></a>
                            
                            <a class="wsis__del_icon remove-sidebar-product" href="#" data-rowid="{{$cartProduct->rowId}}"><i class="fas fa-minus-circle"></i></a>

                        </div>
                        <div class="wsus__cart_text">
                            <a class="wsus__cart_title" href="{{route('product-details',$cartProduct->options->slug)}}">{{$cartProduct->name}}</a>
                            <p>{{$settings->currency_icon . $cartProduct->price}}</p>
                            <small>Variant Total : {{$settings->currency_icon }} {{$cartProduct->options->variants_total_amount}}</small>
                            <br>
                            <small>Qty : {{$cartProduct->qty}}</small>
                        </div>
                    </li>
                @endforeach
            @else
                <li class="text-center"> Cart Is Empty ! </li>
            @endif

        </ul>
        <div class="mini-cart-actions {{Cart::content()->count() == 0 ? 'd-none' : '' }}">
            <h5>sub total <span id="mini_cart_subtotal">{{$settings->currency_icon}} {{getCartSubtotal()}}</span></h5>
            <div class="wsus__minicart_btn_area">
                <a class="common_btn"  href="{{route('cart')}}">view cart</a>
                <a class="common_btn" href="{{route('user.checkout')}}">checkout</a>
            </div>
        </div>
    </div>

</header>