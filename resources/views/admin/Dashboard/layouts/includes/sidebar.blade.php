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
          'admin.coupons.*',
          'admin.shipping-rules.*',
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Ecommerce</span></a>
          <ul class="dropdown-menu">

            <li class="{{setActive(['admin.flash-sale.*'])}}" ><a class="nav-link" href="{{route('admin.flash-sale.index')}}">Flash Sale</a></li>
            <li class="{{setActive(['admin.coupons.*'])}}" ><a class="nav-link" href="{{route('admin.coupons.index')}}">Coupon</a></li>
            <li class="{{setActive(['admin.shipping-rules.*'])}}" ><a class="nav-link" href="{{route('admin.shipping-rules.index')}}">Shipping Rule</a></li>
            <li class="{{setActive(['admin.vendor-profile.*'])}}" ><a class="nav-link" href="{{route('admin.vendor-profile.index')}}">Vendor Profile</a></li>
          
          </ul>
        </li>



        {{-- Manage Website  --}}
        <li class="dropdown  {{setActive(['admin.slider.*'])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Website</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.slider.*'])}}"><a class="nav-link" href="{{route('admin.slider.index')}}">Slider</a></li>
            <li class="{{setActive(['admin.home-page-setting.index'])}}"><a class="nav-link" href="{{route('admin.home-page-setting.index')}}">Home Page Setting</a></li>
          </ul>
        </li>

        {{-- Footer --}}
        <li class="dropdown  {{setActive([
          'admin.footer-info.index',
          'admin.footer-socials.*',
          'admin.footer-grid-two.*',
          'admin.footer-grid-three.*',
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Footer</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.footer-info.index'])}}"><a class="nav-link" href="{{route('admin.footer-info.index')}}">Footer Information</a></li>
            <li class="{{setActive(['admin.footer-socials.*'])}}"><a class="nav-link" href="{{route('admin.footer-socials.index')}}">Footer Socials</a></li>
            <li class="{{setActive(['admin.footer-grid-two.*'])}}"><a class="nav-link" href="{{route('admin.footer-grid-two.index')}}">Footer Grid Two</a></li>
            <li class="{{setActive(['admin.footer-grid-three.*'])}}"><a class="nav-link" href="{{route('admin.footer-grid-three.index')}}">Footer Grid Three</a></li>
            
          </ul>
        </li>



        {{-- Order --}}
        <li class="dropdown  {{setActive([
          'admin.order.*',
          'admin.order.pending',
          'admin.order.processing',
          'admin.order.dropped-off',
          'admin.order.shipped',
          'admin.order.out-for-delivery',
          'admin.order.delivered',
          'admin.order.canceled',
          'admin.order.trashed-orders'
          ])}}">

          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Orders</span></a>

          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.order.*'])}}"><a class="nav-link" href="{{route('admin.order.index')}}">All Orders</a></li>

            <li class="{{setActive(['admin.order.pending'])}}"><a class="nav-link" href="{{route('admin.order.pending')}}">All Pending Orders</a></li>
            <li class="{{setActive(['admin.order.processing'])}}"><a class="nav-link" href="{{route('admin.order.processing')}}">All Processing Orders</a></li>
            <li class="{{setActive(['admin.order.dropped-off'])}}"><a class="nav-link" href="{{route('admin.order.dropped-off')}}">All Dropped Off Orders</a></li>
            <li class="{{setActive(['admin.order.shipped'])}}"><a class="nav-link" href="{{route('admin.order.shipped')}}">All Shipped Orders</a></li>
            <li class="{{setActive(['admin.order.out-for-delivery'])}}"><a class="nav-link" href="{{route('admin.order.out-for-delivery')}}">All Out For Delivery Orders</a></li>
            <li class="{{setActive(['admin.order.delivered'])}}"><a class="nav-link" href="{{route('admin.order.delivered')}}">All Delivered Orders</a></li>
            <li class="{{setActive(['admin.order.canceled'])}}"><a class="nav-link" href="{{route('admin.order.canceled')}}">All Canceled Orders</a></li>
            
            <li class="{{setActive(['admin.order.trashed-orders'])}}"><a class="nav-link" href="{{route('admin.order.trashed-orders')}}">All Trashed Orders</a></li>

          </ul>
        </li>


        {{-- Transaction --}}
        <li class="{{setActive(['admin.transaction.index'])}}"><a class="nav-link" href="{{route('admin.transaction.index')}}"><i class="fas fa-cog"></i> <span>All Transactions</span></a></li>

        {{-- Settings  --}}
        <li class="{{setActive(['admin.settings.*'])}}"><a class="nav-link" href="{{route('admin.settings.index')}}"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
        

        {{-- Payment --}}
        <li class="{{setActive(['admin.payment.*'])}}"><a class="nav-link" href="{{route('admin.payment.index')}}"><i class="fas fa-cog"></i> <span>Payment Settings</span></a></li>
       
        {{-- Subscriber --}}
        <li class="{{setActive(['admin.subscriber.*'])}}"><a class="nav-link" href="{{route('admin.subscriber.index')}}"><i class="fas fa-cog"></i> <span>Subscribers</span></a></li>

      </ul>

   
    </aside>
  </div>