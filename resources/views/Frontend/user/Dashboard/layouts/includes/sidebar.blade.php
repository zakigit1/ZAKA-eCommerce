<div class="dashboard_sidebar">
    <span class="close_icon">
      <i class="far fa-bars dash_bar"></i>
      <i class="far fa-times dash_close"></i>
    </span>
    <a href="{{route('home')}}" class="dash_logo"><img src="{{asset('frontend/assets/images/logo.png')}}" alt="logo" class="img-fluid"></a>
    <ul class="dashboard_link">
      <li><a class="bg-success"  href="javascript:;"><i class="fas fa-tachometer"></i>Dashboard</a></li>
      <li><a href="dsahboard_order.html"><i class="fas fa-list-ul"></i> Orders</a></li>
      <li><a href="dsahboard_review.html"><i class="far fa-star"></i> Reviews</a></li>
      <li><a href="dsahboard_wishlist.html"><i class="far fa-heart"></i> Wishlist</a></li>
      <li><a class="{{ setActive(['user.profile.*'])}}" href="{{route('user.profile.index')}}"><i class="far fa-user"></i> My Profile</a></li>
      <li><a class="{{ setActive(['user.address.*'])}}" href="{{route('user.address.index')}}"><i class="fal fa-gift-card"></i> Addresses</a></li>



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