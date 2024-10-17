<div class="dashboard_sidebar">
    <span class="close_icon">
      <i class="far fa-bars dash_bar"></i>
      <i class="far fa-times dash_close"></i>
    </span>
    <a href="{{route('home')}}" class="dash_logo"><img src="{{asset('frontend/assets/images/logo.png')}}" alt="logo" class="img-fluid"></a>
    <ul class="dashboard_link">

      <li><a class="bg-success"  href="{{route('user.dashboard')}}"><i class="fas fa-house-day"></i>Dashboard</a></li>

      <li><a class="{{ setActive(['user.profile.*'])}}" href="{{route('user.profile.index')}}"><i class="fas fa-user-cog"></i> My Profile</a></li>

      <li><a class="{{ setActive(['user.address.*'])}}" href="{{route('user.address.index')}}"><i class="fas fa-map-marker-alt"></i> Addresses</a></li>

      <li><a class="{{ setActive(['user.order.*'])}}" href="{{route('user.order.index')}}"><i class="fas fa-mail-bulk"></i>Orders</a></li>
        
      <li><a class="{{ setActive(['user.product-review.index'])}}" href="{{route('user.product-review.index')}}"><i class="far fa-star"></i>Product Reviews</a></li>
      
      @if(auth()->user()->role != 'vendor') {{-- You can add new condition for check if this vendor have bought any product from our website --}}
        <li><a class="{{ setActive(['user.vendor-request.index'])}}" href="{{route('user.vendor-request.index')}}"><i class="fas fa-user-plus"></i> Vendor Request</a></li>
      @endif


      {{-- Post Method --}}
      {{-- <form method="POST" action="{{ route('logout') }}">
        @csrf
        <li>
          <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="far fa-sign-out-alt"></i> 
            Log out
          </a>
        </li>
      </form> --}}

      {{-- GET Method --}}
      <li><a href="{{route('user.logout')}}"><i class="far fa-sign-out-alt"></i> Log out</a></li>
        
      

          

      
    </ul>
  </div>