<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('home')}}">Stisla</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{route('home')}}">St</a>
      </div>
      <ul class="sidebar-menu">
  
        <li class="menu-header">Dashboard</li>
        
        <li class="dropdown bg-success">
          <a class="nav-link  " href="{{route('admin.dashboard')}}"><i class="far fa-square"></i> <span>Dashboard</span></a>
        </li>

        <li class="menu-header">STARTER</li>
        
        <li class="dropdown  {{setActive(['admin.slider.*'])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Website</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.slider.*'])}}"><a class="nav-link" href="{{route('admin.slider.index')}}">Slider</a></li>

          </ul>
        </li>

        <li class="dropdown {{setActive([
          'admin.category.*',
          'admin.sub-category.*',
          'admin.child-category.*',
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Categories</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.category.*'])}}" ><a class="nav-link" href="{{route('admin.category.index')}}">Category</a></li>
            <li class="{{setActive(['admin.sub-category.*'])}}"><a class="nav-link" href="{{route('admin.sub-category.index')}}">Subcategory</a></li>
            <li class="{{setActive(['admin.child-category.*'])}}"><a class="nav-link" href="{{route('admin.child-category.index')}}">Childcategory</a></li>

          </ul>
        </li>



        {{-- <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
            <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
            <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
          </ul>
        </li> --}}



        <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>

      </ul>

   
    </aside>
  </div>