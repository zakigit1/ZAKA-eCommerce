<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="javascript:;">{{$settings->site_name}}</a>
        {{-- <a href="{{route('home')}}" class="dash_logo"><img src="{{$logoSettings->logo}}" alt="logo" class="img-fluid"></a> --}}
        
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{route('home')}}">{{$settings->site_name}}</a>
      </div>
      <ul class="sidebar-menu">
  
        <li class="menu-header">Dashboard</li>
        
        <li class="dropdown bg-success">
          <a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fas fa-tachometer-alt"></i>
            <span><b>Dashboard</b></span></a>
        </li>

        <li class="menu-header">Store</li>

        <li class="dropdown bg-warning">
          <a class="nav-link " href="{{route('home')}}"><i class="fas fa-arrow-left"></i> <span><b>Go To Store</b></span></a>
        </li>

        <li class="menu-header">Ecommerce</li>

        {{-- Manage Categories --}}
        <li class="dropdown {{setActive([
          'admin.category.*',
          'admin.sub-category.*',
          'admin.child-category.*',
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list"></i> <span>Manage Categories</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.category.*'])}}" ><a class="nav-link" href="{{route('admin.category.index')}}"> Category</a></li>
            <li class="{{setActive(['admin.sub-category.*'])}}"><a class="nav-link" href="{{route('admin.sub-category.index')}}">Subcategory</a></li>
            <li class="{{setActive(['admin.child-category.*'])}}"><a class="nav-link" href="{{route('admin.child-category.index')}}">Childcategory</a></li>

          </ul>
        </li>

        {{-- Manage Products --}}
        <li class="dropdown {{setActive([
          'admin.brand.*',
          'admin.product.*',
          'admin.product-image-gallery.*',
          'admin.product-variant.*',
          'admin.product-variant-item.*',
          'admin.seller-product.*',
          'admin.seller-pending-product.*',
          'admin.product-review.*',
          'admin.product-review-gallery',
          'admin.all-product.*',

          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i> <span>Manage Products</span></a>
          <ul class="dropdown-menu">
            
            <li class="{{setActive(['admin.brand.*'])}}" ><a class="nav-link" href="{{route('admin.brand.index')}}">Brand</a></li>
            
            <li class="{{setActive([
              'admin.product.*',
              'admin.product-image-gallery.*',
              'admin.product-variant.*',
              'admin.product-variant-item.*',
            ])}}" ><a class="nav-link" href="{{route('admin.product.index')}}">Admin Product</a></li>

            <li class="{{setActive(['admin.all-product.*'])}}" ><a class="nav-link" href="{{route('admin.all-product.index')}}">Product</a></li>
            

            <li class="{{setActive(['admin.seller-product.*'])}}" ><a class="nav-link" href="{{route('admin.seller-product.index')}}">Seller Product</a></li>
            <li class="{{setActive(['admin.seller-pending-product.*'])}}" ><a class="nav-link" href="{{route('admin.seller-pending-product.index')}}">Seller Pending Product</a></li>
           
            <li class="{{setActive([
              'admin.product-review.*',
              'admin.product-review-gallery',
            
            ])}}" ><a class="nav-link" href="{{route('admin.product-review.index')}}">Product Reviews</a></li>
            
            


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

          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cart-plus"></i> <span>Orders</span></a>

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
        <li class="{{setActive(['admin.transaction.index'])}}"><a class="nav-link" href="{{route('admin.transaction.index')}}"><i class="fas fa-money-check-alt"></i><span>All Transactions</span></a></li>

        {{-- Ecommerce --}}
        <li class="dropdown {{setActive([
          'admin.vendor-profile.*',
          'admin.flash-sale.*',
          'admin.coupons.*',
          'admin.shipping-rules.*',
          'admin.payment.*'
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-stream"></i><span>Ecommerce</span></a>
          <ul class="dropdown-menu">

            <li class="{{setActive(['admin.flash-sale.*'])}}" ><a class="nav-link" href="{{route('admin.flash-sale.index')}}">Flash Sale</a></li>
            <li class="{{setActive(['admin.coupons.*'])}}" ><a class="nav-link" href="{{route('admin.coupons.index')}}">Coupon</a></li>
            <li class="{{setActive(['admin.shipping-rules.*'])}}" ><a class="nav-link" href="{{route('admin.shipping-rules.index')}}">Shipping Rule</a></li>
            <li class="{{setActive(['admin.vendor-profile.*'])}}" ><a class="nav-link" href="{{route('admin.vendor-profile.index')}}">Vendor Profile</a></li>
            <li class="{{setActive(['admin.payment.*'])}}"><a class="nav-link" href="{{route('admin.payment.index')}}">Payment Settings</a></li>
          </ul>
        </li>

        {{-- Withdraw Payment   --}}
        <li class="dropdown  {{setActive([
          'admin.withdraw-method.*',
          'admin.withdraw-request-list.*',

          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-wallet"></i><span>Withdraw Payment</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.withdraw-method.*'])}}"><a class="nav-link" href="{{route('admin.withdraw-method.index')}}">Withdraw Methods</a></li>
            <li class="{{setActive(['admin.withdraw-request-list.*'])}}"><a class="nav-link" href="{{route('admin.withdraw-request-list.index')}}">Withdraw Request List </a></li>
            

          </ul>
        </li>

        {{-- Manage Website  --}}
        <li class="dropdown  {{setActive([
            'admin.slider.*',
            'admin.home-page-setting.index',
            'admin.vendor-condition.index',
            'admin.about.index',
            'admin.terms-and-conditions.index',
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i><span>Manage Website</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.slider.*'])}}"><a class="nav-link" href="{{route('admin.slider.index')}}">Slider</a></li>
            <li class="{{setActive(['admin.home-page-setting.index'])}}"><a class="nav-link" href="{{route('admin.home-page-setting.index')}}">Home Page Setting</a></li>
            <li class="{{setActive(['admin.vendor-condition.index'])}}"><a class="nav-link" href="{{route('admin.vendor-condition.index')}}">Vendor Condition</a></li>
            <li class="{{setActive(['admin.about.index'])}}"><a class="nav-link" href="{{route('admin.about.index')}}">About</a></li>
            <li class="{{setActive(['admin.terms-and-conditions.index'])}}"><a class="nav-link" href="{{route('admin.terms-and-conditions.index')}}">Terms & Conditions</a></li>
          </ul>
        </li>

        {{-- Advertisements --}}
        <li class="{{setActive(['admin.advertisement.*'])}}"><a class="nav-link" href="{{route('admin.advertisement.index')}}"><i class='fas fa-ad'></i><span>Advertisements</span></a></li>

        {{-- Manage Blog  --}}
        <li class="dropdown  {{setActive([
          'admin.blog-category.*',
          'admin.blog.*',
          'admin.blog-comment.*',

          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fab fa-blogger-b"></i> <span>Manage Blog</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.blog-category.*'])}}"><a class="nav-link" href="{{route('admin.blog-category.index')}}">Blog Categories</a></li>
            <li class="{{setActive(['admin.blog.*'])}}"><a class="nav-link" href="{{route('admin.blog.index')}}">Blogs</a></li>
            <li class="{{setActive(['admin.blog-comment.*'])}}"><a class="nav-link" href="{{route('admin.blog-comment.index')}}">Blog Comments</a></li>

          </ul>
        </li>

        {{-- Messanger --}}
        <li class="{{setActive(['admin.messager.index'])}}"><a class="nav-link" href="{{route('admin.messager.index')}}"><i class="fas fa-comment-alt"></i><span>Messanger</span></a></li>
        






        {{-- ######################################################################################################## --}}
        <li class="menu-header">Settings & More</li>


        {{-- Settings  --}}
        <li class="{{setActive(['admin.settings.*'])}}"><a class="nav-link" href="{{route('admin.settings.index')}}"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
        

        {{-- Users --}}
        <li class="dropdown {{setActive([
            'admin.vendor-request.*',
            'admin.customer-list.index',
            'admin.vendor-list.index',
            'admin.manage-user.index',
            'admin.admin-list.index',
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>Users</span></a>
          <ul class="dropdown-menu">


            <li class="{{setActive(['admin.customer-list.index'])}}"><a class="nav-link" href="{{route('admin.customer-list.index')}}">Customer List</a></li>
            <li class="{{setActive(['admin.vendor-list.index'])}}"><a class="nav-link" href="{{route('admin.vendor-list.index')}}">Vendor List</a></li>



            <li class="{{setActive(['admin.vendor-request.index',
            'admin.vendor-request.show'])}}" ><a class="nav-link" href="{{route('admin.vendor-request.index')}}">Vendor Request</a></li>
            
            <li class="{{setActive(['admin.vendor-request.pending'])}}"><a class="nav-link" href="{{route('admin.vendor-request.pending')}}">Pending Vendor Request</a></li>
            <li class="{{setActive(['admin.vendor-request.approved'])}}"><a class="nav-link" href="{{route('admin.vendor-request.approved')}}">Approved Vendor Request</a></li>
           
           
           
            <li class="{{setActive(['admin.admin-list.index'])}}"><a class="nav-link" href="{{route('admin.admin-list.index')}}">Admin List</a></li>
            <li class="{{setActive(['admin.manage-user.index'])}}"><a class="nav-link" href="{{route('admin.manage-user.index')}}">Manage User</a></li>

          </ul>
        </li>


        {{-- Subscriber --}}
        <li class="{{setActive(['admin.subscriber.*'])}}"><a class="nav-link" href="{{route('admin.subscriber.index')}}"><i class="fas fa-handshake"></i> <span>Subscribers</span></a></li>
        

        {{-- Footer --}}
        <li class="dropdown  {{setActive([
          'admin.footer-info.index',
          'admin.footer-socials.*',
          'admin.footer-grid-two.*',
          'admin.footer-grid-three.*',
          ])}}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-th-large"></i><span>Footer</span></a>
          <ul class="dropdown-menu">
            <li class="{{setActive(['admin.footer-info.index'])}}"><a class="nav-link" href="{{route('admin.footer-info.index')}}">Footer Information</a></li>
            <li class="{{setActive(['admin.footer-socials.*'])}}"><a class="nav-link" href="{{route('admin.footer-socials.index')}}">Footer Socials</a></li>
            <li class="{{setActive(['admin.footer-grid-two.*'])}}"><a class="nav-link" href="{{route('admin.footer-grid-two.index')}}">Footer Grid Two</a></li>
            <li class="{{setActive(['admin.footer-grid-three.*'])}}"><a class="nav-link" href="{{route('admin.footer-grid-three.index')}}">Footer Grid Three</a></li>
            
          </ul>
        </li>

      </ul>

   
    </aside>
  </div>