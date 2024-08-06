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
        <li class="dropdown {{setActive([
          'admin.brand.*',
          'admin.product.*',
          'admin.product-image-gallery.*',
          'admin.product-variant.*',
          'admin.product-variant-item.*',
          'admin.seller-product.*',
          'admin.seller-pending-product.*'

          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Products</span></a>
          <ul class="dropdown-menu">
            
            <li class="{{setActive(['admin.brand.*'])}}" ><a class="nav-link" href="{{route('admin.brand.index')}}">Brand</a></li>
            
            <li class="{{setActive([
              'admin.product.*',
              'admin.product-image-gallery.*',
              'admin.product-variant.*',
              'admin.product-variant-item.*',
            ])}}" ><a class="nav-link" href="{{route('admin.product.index')}}">Product</a></li>

            <li class="{{setActive(['admin.seller-product.*'])}}" ><a class="nav-link" href="{{route('admin.seller-product.index')}}">Seller Product</a></li>
            <li class="{{setActive(['admin.seller-pending-product.*'])}}" ><a class="nav-link" href="{{route('admin.seller-pending-product.index')}}">Seller Pending Product</a></li>
          
          </ul>
        </li>

        <li class="dropdown {{setActive([
          'admin.vendor-profile.*',
          'admin.flash-sale.*',
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Ecommerce</span></a>
          <ul class="dropdown-menu">

            <li class="{{setActive(['admin.flash-sale.*'])}}" ><a class="nav-link" href="{{route('admin.flash-sale.index')}}">Flash Sale</a></li>
            <li class="{{setActive(['admin.vendor-profile.*'])}}" ><a class="nav-link" href="{{route('admin.vendor-profile.index')}}">Vendor Profile</a></li>
          
          </ul>
        </li>



        
        <li class="dropdown  {{setActive(['admin.slider.*'])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Website</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.slider.*'])}}"><a class="nav-link" href="{{route('admin.slider.index')}}">Slider</a></li>

          </ul>
        </li>




        <li class="{{setActive(['admin.settings.*'])}}"><a class="nav-link" href="{{route('admin.settings.index')}}"><i class="fas fa-cog"></i> <span>Settings</span></a></li>

      </ul>

   
    </aside>
  </div>