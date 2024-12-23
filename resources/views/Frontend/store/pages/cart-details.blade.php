@extends('Frontend.store.layouts.master')

@section('title', @$settings->site_name ." Cart Details")

@section('content')

    <!--============================
                                BREADCRUMB START
                            ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Cart View</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:;">Cart View</a></li>
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


                                    <input type="hidden" class="cart-count" value="{{ count($cartProducts) }}">

                                    @if (isset($cartProducts) && count($cartProducts) > 0)
                                        @foreach ($cartProducts as $cartProduct)
                                            <tr class="d-flex cart-item" id="cart_details_{{ $cartProduct->rowId }}">

                                                <td class="wsus__pro_img"><img
                                                        src="{{ asset($cartProduct->options->image) }}" alt="product"
                                                        class="img-fluid w-100">
                                                </td>

                                                <td class="wsus__pro_name">

                                                    <p>{!! $cartProduct->name !!}</p>

                                                    @foreach ($cartProduct->options->variants as $key => $variantItem)
                                                        <span>{{ $key }}: {{ $variantItem['name'] }}
                                                            ({{ $settings->currency_icon . $variantItem['price'] }})
                                                        </span>
                                                    @endforeach

                                                </td>

                                                <td class="wsus__pro_status">
                                                    <h6>{{ $settings->currency_icon . $cartProduct->price }}</h6>
                                                </td>

                                                <td class="wsus__pro_tk">

                                                    <h6 id="{{ $cartProduct->rowId }}">
                                                        {{ $settings->currency_icon . ($cartProduct->price + $cartProduct->options->variants_total_amount) * $cartProduct->qty }}
                                                    </h6>

                                                </td>

                                                <td class="wsus__pro_select">

                                                    <div class="product_qty_wrapper">
                                                        <button class="btn btn-danger product-decrement"> - </button>
                                                        <input id='qty_val_max' class="product_qty"
                                                            data-rowid="{{ $cartProduct->rowId }}" type="text"
                                                            min="1" max="19" value="{{ $cartProduct->qty }}"
                                                            readonly />
                                                        <button class="btn btn-success product-increment"> + </button>
                                                        {{-- <button class="btn btn-success product-increment" onclick="checkIncrementQuantity(this)"> + </button> --}}
                                                    </div>

                                                </td>

                                                <td class="wsus__pro_icon">
                                                    {{-- <a class="delete-item-with-ajax" href="{{route('remove-product-form-cart',$cartProduct->rowId)}}"><i class="far fa-times"></i></a> --}}

                                                    {{-- using ajax request method  --}}
                                                    <a class="remove-product"
                                                        data-url-product="{{ route('remove-product-form-cart', $cartProduct->rowId) }}"><i
                                                            class="far fa-times"></i></a>

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

                        <p>subtotal: <span id="cart_subtotal">{{ $settings->currency_icon }}
                                {{ getCartSubtotal() }}</span></p>


                        <p>
                            <span id="discount_type_cart">Coupon (-
                                {{ session()->has('coupon') ? (session()->get('coupon')['discount_type'] == 'amount' ? $settings->currency_icon . session()->get('coupon')['discount'] : session()->get('coupon')['discount_percentage'] . '%') : '' }}):</span>
                            <span id="cart_discount">{{ $settings->currency_icon }} {{ cartDiscount() }}</span>
                        </p>



                        {{-- <p>
                                <span id="discount_type_cart">Coupon (-):</span>
                                <span id="cart_discount">{{$settings->currency_icon}} {{cartDiscount()}}</span>
                            </p> --}}


                        <p class="total"><span>total:</span> <span id="cart_total">{{ $settings->currency_icon }}
                                {{ cartTotal() }}</span></p>

                        <form id="coupon_form">
                            <input type="text" placeholder="Coupon Code" name="coupon_code"
                                value="{{ session()->has('coupon') ? session()->get('coupon')['coupon_code'] : '' }}">
                            <button type="submit" class="common_btn">apply</button>
                        </form>

                        <a class="common_btn mt-4 w-100 text-center" href="{{ route('user.checkout') }}">checkout</a>
                        <a class="common_btn mt-1 w-100 text-center" href="{{ route('home') }}"><i
                                class="fab fa-shopify"></i> Keep Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- banners --}}

    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_img">

                            @if ($cartpageBanner[2]->status == 1)
                                <a href="{{ $cartpageBanner[0]->banner_1->banner_url_1 }}">
                                    <img src="{{ asset($cartpageBanner[0]->banner_1->banner_image_1) }}" alt="banner"
                                        class="img-fluid w-100">
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            @if ($cartpageBanner[2]->status == 1)
                                <a href="{{ $cartpageBanner[1]->banner_2->banner_url_2 }}">
                                    <img src="{{ asset($cartpageBanner[1]->banner_2->banner_image_2) }}" alt="banner"
                                        class="img-fluid w-100">
                                </a>
                            @endif
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
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /** increment Quantity :   */
            $('.product-increment').on('click', function() {

                let input = $(this).siblings('.product_qty');
                let quantity = parseInt(input.val()) + 1;
                let rowId = input.data('rowid');

                // alert (input);
                input.val(quantity); // they will change number of quantity in side the qty box 

                $.ajax({
                    url: '{{ route('cart-qty-update') }}',
                    method: 'POST',
                    data: {
                        rowId: rowId,
                        quantity: quantity
                    },

                    success: function(data) {
                        if (data.status == 'success') {

                            let productId = '#' + rowId;
                            let productTotalAmount = "{{ $settings->currency_icon }}" + data
                                .product_total_amount

                            // console.log($(productId).text());
                            $(productId).text(productTotalAmount);

                            getCartSubtotal()
                            calculateCouponDiscount()
                            toastr.success(data.message);

                        } else if (data.status == 'warning') {

                            input.val(data.qty_max);
                            toastr.warning(data.message);

                            // toastr.warning(data.message);
                        }
                    },
                    error: function(data) {
                        console.log('error');
                    }
                });
            });

            /** decrement Quantity :  */
            $('.product-decrement').on('click', function() {

                let input = $(this).siblings('.product_qty');
                let quantity = parseInt(input.val()) - 1;
                let rowId = input.data('rowid');

                if (quantity < 1) {
                    quantity = 1;
                }

                input.val(quantity); // they will change number of quantity in side the qty box 

                $.ajax({
                    url: '{{ route('cart-qty-update') }}',
                    method: 'POST',
                    data: {
                        rowId: rowId,
                        quantity: quantity
                    },

                    success: function(data) {
                        if (data.status == 'success') {

                            let productId = '#' + rowId;
                            let productTotalAmount = "{{ $settings->currency_icon }}" + data
                                .product_total_amount

                            // console.log($(productId).text());
                            $(productId).text(productTotalAmount);

                            getCartSubtotal()
                            calculateCouponDiscount()
                            toastr.success(data.message);

                        } else if (data.status == 'warning') {

                            toastr.warning(data.message);

                        }
                    },
                    error: function(data) {
                        console.log('error');
                    }
                });
            });

            /** remove product from the cart (AJAX Request no-reload):  */
            $('body').on('click', '.remove-product', function() {

                $.ajax({
                    url: $(this).attr('data-url-product'),
                    type: 'get',

                    success: function(data) {

                        if (data.status == 'success') {

                            let productId = "#cart_details_" + data.rowId;
                            $(productId).remove()
                            removeProductSidebar(data.rowId)
                            getCartCount()
                            getCartSubtotal()
                            calculateCouponDiscount()
                            if ($(".cart-item").length == 0) {
                                // window.location.reload();
                                setTimeout(function() {
                                    window.location.href = "{{ route('home') }}";
                                }, 1000); // 30000 milliseconds = 30 seconds ,1000 = 1 second
                            }




                            toastr.success(data.message);

                        } else if (data.status == 'error') {
                            toastr.warning(data.message);

                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    },

                });
            });

            /** Clear Cart : */
            $('.clear-cart').on('click', function(e) {
                e.preventDefault();

                // Check if cart is empty
                var cartCount = parseInt($('.cart-count')
                    .val()); // assuming you have a #cart-count element that displays the cart count
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
                            url: "{{ route('clear-cart') }}",
                            success: function(data) {
                                if (data.status === 'success') {
                                    // window.location.reload();
                                    setTimeout(function() {
                                    window.location.href = "{{ route('home') }}";
                                    }, 1000); // 30000 milliseconds = 30 seconds ,1000 = 1 second

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

            /** Coupon apply :  */

            $('#coupon_form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                $.ajax({
                    method: 'GET',
                    url: "{{ route('apply-coupon') }}",
                    data: formData,

                    success: function(data) {
                        if (data.status == 'error') {
                            toastr.error(data.message);
                        } else if (data.status == 'success') {
                            calculateCouponDiscount()
                            toastr.success(data.message);

                        }
                    },
                    error: function(data) {}
                });
            });


            //Function Ajax :

            /** just hide the product form side bar : */
            function removeProductSidebar(rowId) {
                let productId = '#mini_cart_' + rowId;
                $(productId).remove()

                if ($('.mini-cart-wrapper').find('li').length == 0) {

                    $('.mini-cart-actions').addClass('d-none');
                    $('.mini-cart-wrapper').html('<li class="text-center"> Cart Is Empty ! </li>');
                    // $.('#cart-count').text(0);
                }


            }

            /** dispaly cart counter  (dont remove it from here) :*/
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

            /** get subtotal in the cart details : */
            function getCartSubtotal() {
                $.ajax({
                    url: "{{ route('cart-get-total-products-sidebar') }}",
                    method: 'GET',

                    success: function(data) {
                        $('#cart_subtotal').text("{{ $settings->currency_icon }}" + data);

                        // also for the sidebar subtotal
                        $('#mini_cart_subtotal').text("{{ $settings->currency_icon }}" + data);

                    },
                    error: function(data) {
                        console.log('error');
                    }
                });
            }

            /** Calculate Coupon Discount :  */
            function calculateCouponDiscount() {

                $.ajax({
                    method: 'GET',
                    url: "{{ route('calculate-coupon-discount') }}",
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#cart_discount').text("{{ $settings->currency_icon }}" + data.discount);
                            $('#cart_total').text("{{ $settings->currency_icon }}" + data.total);
                            $('#discount_type_cart').text("Coupon (-" + data.discountType + ")");
                        }
                    },
                    error: function(data) {
                        console.log('error');
                    }
                });
            }
        });
    </script>
@endpush
