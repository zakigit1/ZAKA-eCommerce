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

<section id="wsus__mobile_menu">

    <span class="wsus__mobile_menu_close"><i class="fal fa-times"></i></span>

    <ul class="wsus__mobile_menu_header_icon d-inline-flex">

            {{-- @if (Route::has('login')) --}}
            
            @auth
                {{-- it mean (admin.dashboard Or user.dashboard Or vendor.dashboard) --}}
                <li><a href="{{route('user.dashboard')}}"><i class="fas fa-user"></i></a></li>
                
            @else
                {{-- <li><a href="{{route('login')}}">Login</a></li> --}}
                @if (Route::has('register'))
                    <li><a href="{{route('register')}}"><i class="fas fa-sign-in"></i></a></li>
                @endif
            @endauth    

  
            @auth()
                <li>
                    <a href="{{route('user.wishlist.index')}}"><i class="far fa-heart"></i>
                        <span id="wishlist_count">
                            {{\App\Models\Wishlist::where('user_id' , auth()->user()->id)->count()}}    
                        </span>
                    </a>
                </li>
            @endauth
            {{-- <li><a href="compare.html"><i class="far fa-random"></i> </i><span>3</span></a></li> --}}

        </ul>
    </ul>

 
    <form action="{{route('products.index')}}" method="GET"> 
        <input type="text" placeholder="Search..." name="search" value="{{request()->search}}">
        <button type="submit"><i class="far fa-search"></i></button>
    </form>



    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link list-view {{session()->has('mobile_menu_view_list') && session()->get('mobile_menu_view_list') == 'main-menu' ? 'active' : ''}} 
                {{!session()->has('mobile_menu_view_list') ? 'active' : '' }}"
                data-id="main-menu" 
                data-bs-toggle="pill" data-bs-target="#pills-profile" id="pills-profile-tab" 
                role="tab" aria-controls="pills-profile" aria-selected="false">main menu</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link list-view {{session()->has('mobile_menu_view_list') && session()->get('mobile_menu_view_list') == 'categories-drop-down' ? 'active' : ''}}"  
                data-id="categories-drop-down" 
                id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                role="tab" aria-controls="pills-home" aria-selected="true">Categories</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade {{session()->has('mobile_menu_view_list') && session()->get('mobile_menu_view_list') == 'main-menu' ? 'show active' : ''}} 
            {{!session()->has('mobile_menu_view_list') ? 'show active' : '' }}"  
            id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="wsus__mobile_menu_main_menu">
                <div class="accordion accordion-flush" id="accordionFlushExample2">

                    <ul class="wsus__mobile_menu_main_menu">
                    
                        <ul>
                            <li><a class="{{ setActive(['home']) }}" href="{{route('home')}}">home</a></li>

                            <li><a class="{{ setActive(['vendor.index']) }}" href="{{route('vendor.index')}}">Vendor</a></li>

                            <li><a class="{{ setActive(['blog']) }}" href="{{route('blog')}}">Blog</a></li>

                            @auth
                                <li><a class="{{ setActive(['user.track-order.index']) }}" href="{{route('user.track-order.index')}}">Track Order</a></li>
                            @endauth

                            <li><a class="{{ setActive(['flash-sale.index']) }}" href="{{route('flash-sale.index')}}">Flash Sale</a></li>
                            
                            <li><a class="{{ setActive(['contact.index']) }}" href="{{route('contact.index')}}">Contact</a></li>
                            {{-- <li><a href="daily_deals.html">daily deals</a></li> --}}
                        </ul>
    
                    </ul>
                </div>
            </div>
        </div>


        <div class="tab-pane fade {{session()->has('mobile_menu_view_list') && session()->get('mobile_menu_view_list') == 'categories-drop-down' ? 'show active' : ''}}"
             id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

            <div class="wsus__mobile_menu_main_menu">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <ul class="wsus_mobile_menu_category">
                        @if(isset($categories) && count($categories) > 0)                              
                            @foreach($categories as $category)
                
                                <li>
                                    <div class="accordion-item">
                                        <a href="{{route('products.index',['category' => $category->slug])}}" 
                                            class="{{(count($category->subcategories) > 0)? 'accordion-button' : ''}} collapsed"  
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseThreew-{{$loop->index}}" 
                                            aria-expanded="false"
                                            aria-controls="flush-collapseThreew">
                                            <i class="{{$category->icon}}"></i> 
                                            
                                                {{$category->name}}
                                        </a>
                
                                        <div class="accordion-collapse collapse"
                                            id="flush-collapseThreew-{{$loop->index}}" 
                                            >
                                            <div class="accordion-body">
                                                @if(isset($category->subcategories) && count($category->subcategories) > 0)
                                                    <ul>
                                                        @foreach($category->subcategories as $subcategory)
                                                            <li>
                                                                <a href="{{route('products.index',['sub_category' => $subcategory->slug])}}" 
                                                                    
                                                                    class="{{(count($subcategory->childcategories) > 0) ? 'accordion-button' : ''}} collapsed"  
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#flush-collapseThree-{{$loop->index}}"
                                                                    aria-expanded="false"
                                                                    aria-controls="flush-collapseThree">
                                                                    {{$subcategory->name}}
                                                                </a>
                
                                                                <div class="accordion-collapse collapse"
                                                                    id="flush-collapseThree-{{$loop->index}}" 
                                                                    >
                                                                    <div class="accordion-body">
                                                                        @if(isset($subcategory->childcategories) && count($subcategory->childcategories) > 0)
                                                                            <ul>
                                                                                @foreach($subcategory->childcategories as $childcategory)
                                                                                    <li>
                                                                                        <a href="{{route('products.index',['child_category' => $childcategory->slug])}}">
                                                                                            {{$childcategory->name}}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                
                
                
                        <li><a href="#"><i class="fal fa-gem"></i> View All Categories</a></li>
                    </ul>
                </div>


                {{-- <div class="accordion accordion-flush" id="accordionFlushExample">
                    <ul class="wsus_mobile_menu_category">
                        @if(isset($categories) && count($categories) > 0)                              
                            @foreach($categories as $category)

                                <li>
                                    <a href="{{route('products.index',['category' => $category->slug])}}" 
                                        class="{{(count($category->subcategories) > 0)? 'accordion-button' : ''}} collapsed"  
                                        data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThreew-{{$loop->index}}" 
                                        aria-expanded="false"
                                        aria-controls="flush-collapseThreew">
                                        <i class="{{$category->icon}}"></i> 
                                        
                                            {{$category->name}}
                                    </a>

                                    <div class="accordion-collapse collapse"
                                        id="flush-collapseThreew-{{$loop->index}}" 
                                        @if(isset($subcategory->childcategories) && count($subcategory->childcategories) > 0) data-bs-parent="#accordionFlushExample-{{$loop->index}}" @endif
                                        >
                                        <div class="accordion-body">
                                            @if(isset($category->subcategories) && count($category->subcategories) > 0)
                                                <ul>
                                                    @foreach($category->subcategories as $subcategory)
                                                        <li>
                                                            <a href="{{route('products.index',['sub_category' => $subcategory->slug])}}" 
                                                                
                                                                class="{{(count($subcategory->childcategories) > 0) ? 'accordion-button' : ''}} collapsed"  
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#flush-collapseThree-{{$loop->index}}"
                                                                aria-expanded="false"
                                                                aria-controls="flush-collapseThree">
                                                                {{$subcategory->name}}
                                                            </a>

                                                            <div class="accordion-collapse collapse"
                                                                id="flush-collapseThree-{{$loop->index}}" 
                                                                data-bs-parent="#accordionFlushExample-{{$loop->index}}">
                                                                <div class="accordion-body">
                                                                    @if(isset($subcategory->childcategories) && count($subcategory->childcategories) > 0)
                                                                        <ul>
                                                                            @foreach($subcategory->childcategories as $childcategory)
                                                                                <li>
                                                                                    <a href="{{route('products.index',['child_category' => $childcategory->slug])}}">
                                                                                        {{$childcategory->name}}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif



                        <li><a href="#"><i class="fal fa-gem"></i> View All Categories</a></li>
                    </ul>
                </div> --}}
            </div>

        </div>




    </div>
</section>


@push('scripts')
    <script>
          $(document).ready(function(){

              $('.list-view').on('click', function(){

                  let style = $(this).data('id');
                  
                  $.ajax({
                      method: 'GET',
                      url: '{{route("mobile-menu.view-list")}}',
                      data: {
                          style: style,
                      },
                      success: function(data){

                      }
                  });
              });

          });
    </script> 
@endpush