@extends('Frontend.store.layouts.master')

@section('title', "$settings->site_name || Cart Details")

@section('content')

    <!--============================
            BREADCRUMB START
        ==============================-->
        <section id="wsus__breadcrumb">
            <div class="wsus_breadcrumb_overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h4>cart View</h4>
                            <ul>
                                <li><a href="{{route('home')}}">home</a></li>
                                <li><a href="#">product</a></li>
                                <li><a href="javascript:;">cart view</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!--============================
            BREADCRUMB END
        ==============================-->


    <!--============================
            CART VIEW PAGE START
        ==============================-->
        <section id="wsus__cart_view">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9">
                        <div class="wsus__cart_list">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr class="d-flex">
                                            <th class="wsus__pro_img">
                                                product item
                                            </th>

                                            <th class="wsus__pro_name">
                                                product details
                                            </th>

                                            <th class="wsus__pro_status">
                                                unit price
                                            </th>

                                            <th class="wsus__pro_tk">
                                                total price
                                            </th>
                                            <th class="wsus__pro_select">
                                                quantity
                                            </th>

                                            <th class="wsus__pro_icon">
                                                
                                                <a class="common_btn clear-cart">clear cart</a>
                                            </th>
                                        </tr>

                                        
                                        <input type="hidden" class="cart-count" value="{{count($cartProducts)}}">
                                        
                                        @if(isset($cartProducts) && count($cartProducts) > 0)
                                            @foreach ($cartProducts as $cartProduct)
                                                
                                                <tr class="d-flex cart-item" id="cart_details_{{$cartProduct->rowId}}">

                                                    <td class="wsus__pro_img"><img src="{{asset($cartProduct->options->image)}}" alt="product"
                                                            class="img-fluid w-100">
                                                    </td>

                                                    <td class="wsus__pro_name">

                                                        <p>{!! $cartProduct->name !!}</p>

                                                        @foreach ($cartProduct->options->variants as $key => $variantItem)
                                                            <span>{{$key}}: {{$variantItem['name']}} ({{$settings->currency_icon.$variantItem['price']}})</span> 
                                                        @endforeach
      
                                                    </td>

                                                    <td class="wsus__pro_status">
                                                        <h6>{{$settings->currency_icon . $cartProduct->price}}</h6>
                                                    </td>

                                                    <td class="wsus__pro_tk">
                                                        
                                                        <h6 id="{{$cartProduct->rowId}}">{{$settings->currency_icon . ($cartProduct->price + $cartProduct->options->variants_total_amount) * $cartProduct->qty }}</h6>
                                                        
                                                    </td>

                                                    <td class="wsus__pro_select">

                                                        <div class="product_qty_wrapper">
                                                            <button class="btn btn-danger product-decrement"> - </button>
                                                            <input class="product_qty" data-rowid="{{$cartProduct->rowId}}"  type="text" min="1" max="100"
                                                                value="{{$cartProduct->qty}}" readonly/>
                                                            <button class="btn btn-success product-increment"> + </button>
                                                        </div>

                                                    </td>

                                                    <td class="wsus__pro_icon">
                                                        {{-- <a class="delete-item-with-ajax" href="{{route('remove-product-form-cart',$cartProduct->rowId)}}"><i class="far fa-times"></i></a> --}}
                                                        
                                                        {{-- using ajax request method  --}}
                                                        <a class="remove-product" data-url-product="{{route('remove-product-form-cart',$cartProduct->rowId)}}"><i class="far fa-times"></i></a>
                                                        
                                                        {{-- normal request --}}
                                                        {{-- <a  href="{{route('remove-product-form-cart',$cartProduct->rowId)}}"><i class="far fa-times"></i></a> --}}
  
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="d-flex">
                                                            
                                                <td class="wsus__pro_icon" rowspan="2" style="width: 100%">
                                                    Cart Is Empty ! 
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                            <h6>total cart</h6>
                            <p>subtotal: <span id="cart_subtotal">{{$settings->currency_icon}} {{getCartTotal()}}</span></p>
                            <p>delivery: <span>$00.00</span></p>
                            <p>discount: <span>$10.00</span></p>
                            <p class="total"><span>total:</span> <span>$134.00</span></p>

                            <form>
                                <input type="text" placeholder="Coupon Code">
                                <button type="submit" class="common_btn">apply</button>
                            </form>
                            <a class="common_btn mt-4 w-100 text-center" href="check_out.html">checkout</a>
                            <a class="common_btn mt-1 w-100 text-center" href="product_grid_view.html"><i
                                    class="fab fa-shopify"></i> go shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="wsus__single_banner">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="wsus__single_banner_content">
                            <div class="wsus__single_banner_img">
                                <img src="{{asset('frontend/assets/images/single_banner_2.jpg')}}" alt="banner" class="img-fluid w-100">
                            </div>
                            <div class="wsus__single_banner_text">
                                <h6>sell on <span>35% off</span></h6>
                                <h3>smart watch</h3>
                                <a class="shop_btn" href="#">shop now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="wsus__single_banner_content single_banner_2">
                            <div class="wsus__single_banner_img">
                                <img src="{{asset('frontend/assets/images/single_banner_3.jpg')}}" alt="banner" class="img-fluid w-100">
                            </div>
                            <div class="wsus__single_banner_text">
                                <h6>New Collection</h6>
                                <h3>Cosmetics</h3>
                                <a class="shop_btn" href="#">shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!--============================
              CART VIEW PAGE END
        ==============================-->

@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // increment Quantity : 
            $('.product-increment').on('click',  function(){
            
                let input = $(this).siblings('.product_qty');
                let quantity = parseInt(input.val()) + 1;
                let rowId = input.data('rowid');
                
                input.val(quantity); // they will change number of quantity in side the qty box 

                $.ajax({
                    url: '{{route("cart-qty-update")}}',
                    method: 'POST',
                    data: {
                        rowId: rowId,
                        quantity: quantity
                    },

                    success: function(data){
                        if (data.status == 'success') {

                            let productId = '#'+rowId;
                            let productTotalAmount  ="{{$settings->currency_icon}}"+data.product_total_amount
                            
                            // console.log($(productId).text());
                            $(productId).text(productTotalAmount);

                            getCartSubtotal()
                            toastr.success(data.message);

                        }else if(data.status == 'warning'){ 

                            toastr.warning(data.message);
  
                        }
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            // decrement Quantity : 
            $('.product-decrement').on('click',  function(){
            
                let input = $(this).siblings('.product_qty');
                let quantity = parseInt(input.val()) - 1;
                let rowId = input.data('rowid');
                
                if(quantity < 1){
                    quantity = 1;
                }

                input.val(quantity); // they will change number of quantity in side the qty box 

                $.ajax({
                    url: '{{route("cart-qty-update")}}',
                    method: 'POST',
                    data: {
                        rowId: rowId,
                        quantity: quantity
                    },

                    success: function(data){
                        if (data.status == 'success') {

                            let productId = '#'+rowId;
                            let productTotalAmount  ="{{$settings->currency_icon}}"+data.product_total_amount
                            
                            // console.log($(productId).text());
                            $(productId).text(productTotalAmount);

                            getCartSubtotal()
                            toastr.success(data.message);

                        }else if(data.status == 'warning'){ 

                            toastr.warning(data.message);
 
                        }
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            // remove product from the cart (AJAX Request no-reload): 
            $('body').on('click', '.remove-product', function(){
                
                $.ajax({
                    url: $(this).attr('data-url-product'),
                    type: 'get',
                    
                    success: function(data){
                    
                        if (data.status == 'success') {

                            let productId = "#cart_details_" + data.rowId;
                            $(productId).remove()
                            removeProductSidebar(data.rowId)
                            getCartCount() 
                            getCartSubtotal()

                            if($(".cart-item").length == 0){
                                window.location.reload();
                            }   


                            toastr.success(data.message);

                        }else if(data.status == 'error'){ 
                            toastr.warning(data.message);
                        
                            setTimeout(function(){
                                window.location.reload();
                            }, 3000);    
                        }
                    },

                });
            });

            // Clear Cart : 
            $('.clear-cart').on('click', function(e) {
                e.preventDefault();

                  // Check if cart is empty
                  var cartCount = parseInt($('.cart-count').val()); // assuming you have a #cart-count element that displays the cart count
                    if (cartCount === 0) {
                        
                        Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Cart is empty!!",
                        });
                        return false;
                    }

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action will clear your cart!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Clear it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                        $.ajax({
                            type: 'GET',
                            url: "{{route('clear-cart')}}",
                            success: function(data) {
                            if (data.status === 'success') {
                                window.location.reload();
                                // toastr.success(data.message);
                            } else if (data.status === 'error') {
                                toastr.warning(data.message);
                            }
                            },
                            error: function(xhr, status, error) {
                            console.error('Error clearing cart:', error);
                            toastr.error('Error clearing cart. Please try again.');
                            }
                        });
                        }
                    });
            });


            //Function Ajax :

                // just hide the product form side bar : 
                function removeProductSidebar(rowId) {
                    let productId = '#mini_cart_' + rowId;
                    $(productId).remove()

                    if($('.mini-cart-wrapper').find('li').length == 0){

                        $('.mini-cart-actions').addClass('d-none');
                        $('.mini-cart-wrapper').html('<li class="text-center"> Cart Is Empty ! </li>');
                    }   
                }

                //  dispaly cart counter  (dont remove it from here) :
                function getCartCount() {
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('cart-counter') }}",
                        success: function(data) {
                            $('#cart-count').text(data);
                        },
                        error: function(data) {}
                    });
                }
                
                // get subtotal in the cart details :

                function getCartSubtotal(){
                    $.ajax({
                    url: "{{ route('cart-get-total-products-sidebar') }}",
                    method: 'GET',
                    

                    success: function(data) {
                        $('#cart_subtotal').text("{{$settings->currency_icon}}" + data);

                        // also for the sidebar subtotal
                        $('#mini_cart_subtotal').text("{{$settings->currency_icon}}" + data);
                        toastr.success(data.message);
                    },
                    error: function(data) {
                        console.log('error');
                    }
                });
                }

        });
          
     
    </script>
    
@endpush