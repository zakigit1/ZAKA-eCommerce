<div class="dashboard_sidebar">
    <span class="close_icon">
      <i class="far fa-bars dash_bar"></i>
      <i class="far fa-times dash_close"></i>
    </span>
    <a href="{{route('home')}}" class="dash_logo"><img src="{{$logoSettings->logo}}" alt="logo" class="img-fluid"></a>
    {{-- <a href="{{route('home')}}" class="dash_logo"><img src="{{asset('frontend/assets/images/logo.png')}}" alt="logo" class="img-fluid"></a> --}}
    <ul class="dashboard_link">
      <li><a class="bg-success"  href="{{route('vendor.dashboard')}}"><i class="fas fa-tachometer"></i>Dashboard</a></li>
      <li><a class="bg-warning"  href="{{route('home')}}"><i class="fas fa-tachometer"></i>Go To Store</a></li>

      <li><a class="{{ setActive(['vendor.shop-profile.*'])}}" href="{{route('vendor.shop-profile.index')}}"><i class="far fa-heart"></i> Shop Profile</a></li>
      
      <li><a class="{{ setActive(['vendor.profile'])}}" href="{{route('vendor.profile')}}"><i class="far fa-user"></i> My Profile</a></li>
      
      <li><a class="{{ setActive([
          'vendor.product.*',
          'vendor.product-image-gallery.*',
          'vendor.product-variant.*',
          'vendor.product-variant-item.*',
          ])}}" href="{{route('vendor.product.index')}}"><i class="far fa-user"></i> Product</a></li>


      <li><a class="{{ setActive(['vendor.product-review.index'])}}" href="{{route('vendor.product-review.index')}}"><i class="far fa-user"></i>Product Reviews </a></li>
      
      {{-- Widthdraw request --}}
      <li><a class="{{ setActive(['vendor.withdraw.*'])}}" href="{{route('vendor.withdraw.index')}}"><i class="far fa-user"></i>Withdraw Request </a></li>

      <li><a class="{{ setActive([
        'vendor.order.*',
        ])}}" href="{{route('vendor.order.index')}}"><i class="far fa-user"></i>Order</a></li>

   




      {{-- <form method="POST" action="{{ route('logout') }}">
        @csrf
        <li>
          <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="far fa-sign-out-alt"></i> 
            Log out
          </a>
        </li>
      </form> --}}
      <li><a href="{{route('vendor.logout')}}"><i class="far fa-sign-out-alt"></i> Log out</a></li>

    
    </ul>
  </div>