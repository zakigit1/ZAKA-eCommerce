<div class="wsus__dashboard_menu">
    <div class="wsusd__dashboard_user">

        @if(auth()->user()->image && file_exists(public_path(auth()->user()->image)))
            <img src="{{ auth()->user()->image }}" alt="vendor-image" class="img-fluid">
        @else
            <img src="{{ asset('frontend/assets/images/dashboard_user.jpg') }}" alt="default-image" class="img-fluid">
        @endif
        
      <p>{{auth()->user()->name}}</p>
    </div>
  </div>