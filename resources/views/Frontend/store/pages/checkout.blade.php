   @extends('Frontend.store.layouts.master')

   @section('title', "$settings->site_name || Checkout")

   @section('content')


       <!--============================
            BREADCRUMB START
        ==============================-->
       <section id="wsus__breadcrumb">
           <div class="wsus_breadcrumb_overlay">
               <div class="container">
                   <div class="row">
                       <div class="col-12">
                           <h4>Checkout</h4>
                           <ul>
                               <li><a href="{{ route('home') }}">Home</a></li>
                               <li><a href="javascript:;">Checkout</a></li>
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
            CHECK OUT PAGE START
        ==============================-->
       <section id="wsus__cart_view">
           <div class="container">
               <div class="wsus__checkout_form">
                   <div class="row">
                       <div class="col-xl-8 col-lg-7">
                           <div class="wsus__check_form">
                               <h5>Addresses Details <a href="#" data-bs-toggle="modal"
                                       data-bs-target="#exampleModal">add
                                       new address</a></h5>

                               <div class="row">
                                   @if (isset($userAdresses) && count($userAdresses) > 0)
                                       @foreach ($userAdresses as $address)
                                           <div class="col-xl-6">
                                               <div class="wsus__checkout_single_address">
                                                   <div class="form-check">
                                                       <input class="form-check-input shipping_address" type="radio"
                                                           name="flexRadioDefault" id="flexRadioDefault1"
                                                           data-id="{{ $address->id }}">
                                                       <label class="form-check-label" for="flexRadioDefault1">
                                                           Select Address
                                                       </label>
                                                   </div>
                                                   <ul>
                                                       <li><span>Name :</span> {{ $address->name }}</li>
                                                       <li><span>Phone :</span> {{ $address->phone }}</li>
                                                       <li><span>Email :</span> {{ $address->email }}</li>
                                                       <li><span>Country :</span> {{ $address->country }}</li>
                                                       <li><span>State :</span> {{ $address->state }}</li>
                                                       <li><span>City :</span> {{ $address->city }}</li>
                                                       <li><span>Zip Code :</span> {{ $address->zip }}</li>
                                                       <li><span>Address :</span> {{ $address->address }}</li>
                                                   </ul>
                                               </div>
                                           </div>
                                       @endforeach
                                   @endif

                               </div>
                           </div>
                       </div>
                       <div class="col-xl-4 col-lg-5">
                           <div class="wsus__order_details" id="sticky_sidebar">
                               <p class="wsus__product">shipping Methods</p>
                               @if (isset($shippingMethods) && count($shippingMethods) > 0)
                                   @foreach ($shippingMethods as $shippingMethod)
                                       @if ($shippingMethod->type == 'min_cost' && getCartSubtotal() >= $shippingMethod->min_cost)
                                           <div class="form-check">
                                               <input class="form-check-input shipping-method" type="radio"
                                                   name="exampleRadios" id="exampleRadios1"
                                                   value="{{ $shippingMethod->id }}"
                                                   data-id="{{ $shippingMethod->cost }}">

                                               <label class="form-check-label" for="exampleRadios1">
                                                   {{ $shippingMethod->name }}
                                                   <span>cost : {{ $settings->currency_icon }}{{ $shippingMethod->cost }}
                                                       (10 - 12 days)
                                                   </span>
                                               </label>
                                           </div>
                                       @elseif($shippingMethod->type == 'flat_cost')
                                           <div class="form-check">
                                               <input class="form-check-input shipping-method" type="radio"
                                                   name="exampleRadios" id="exampleRadios1"
                                                   value="{{ $shippingMethod->id }}"
                                                   data-id="{{ $shippingMethod->cost }}">
                                               <label class="form-check-label" for="exampleRadios1">
                                                   {{ $shippingMethod->name }}
                                                   <span>cost : {{ $settings->currency_icon }}{{ $shippingMethod->cost }}
                                                       (10 - 12 days)</span>
                                               </label>
                                           </div>
                                       @endif
                                   @endforeach
                               @endif


                               <div class="wsus__order_details_summery">
                                   <p>subtotal: <span>{{ $settings->currency_icon }} {{ getCartSubtotal() }}</span></p>
                                   <p>shipping fee (+): <span id="shipping-fee"
                                           data-id="">{{ $settings->currency_icon }} 0.00</span></p>
                                   <p>coupon (-): <span>{{ $settings->currency_icon }} {{ cartDiscount() }}</span></p>
                                   <p><b>total:</b> <span><b id="total_amount"
                                               data-id="{{ cartTotal() }}">{{ $settings->currency_icon }}
                                               {{ cartTotal() }}</b></span></p>
                               </div>
                               <div class="terms_area">
                                   <div class="form-check">
                                       <input class="form-check-input agree_term" type="checkbox" value=""
                                           id="flexCheckChecked3">

                                       <label class="form-check-label" for="flexCheckChecked3">
                                           I have read and agree to the website <a href="#">terms and conditions *</a>
                                       </label>
                                   </div>
                               </div>
                               <form action="" id="checkOutForm">
                                   <input type="hidden" name="shipping_method_id" value="" id="shipping_method_id">
                                   <input type="hidden" name="shipping_address_id" value="" id="shipping_address_id">
                               </form>

                               <a href="payment.html" id="submitCheckoutForm" class="common_btn">Place Order</a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </section>

       <div class="wsus__popup_address">
           <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                       </div>
                       <div class="modal-body p-0">
                           <div class="wsus__check_form p-3">
                               <div class="row">
                                   <form action="{{ route('user.checkout.add-address') }}" method="POST">
                                       @csrf

                                       <div class="row">
                                           <div class="col-md-6">
                                               <div class="wsus__check_single_form">
                                                   <input type="text" placeholder="Name *" name="name"
                                                       value="{{ old('name') }}">
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="wsus__check_single_form">
                                                   <input type="email" placeholder="Email *" name="email"
                                                       value="{{ old('email') }}">
                                               </div>
                                           </div>
                                       </div>

                                       <div class="row">
                                           <div class="col-md-6">
                                               <div class="wsus__check_single_form">
                                                   <input type="text" placeholder="Phone *" name="phone"
                                                       value="{{ old('phone') }}">
                                               </div>
                                           </div>


                                           <div class="col-md-6">
                                               <div class="wsus__check_single_form">
                                                   <select class="select_2" name="country">

                                                       <option disabled selected>Select</option>
                                                       @foreach (config('settings.country_list') as $country)
                                                           {{-- <option value="{{$country}}">{{$country}}</option> --}}
                                                           <option {{ $country == old('country') ? 'selected' : '' }}
                                                               value="{{ $country }}">{{ $country }}</option>
                                                       @endforeach

                                                   </select>
                                               </div>
                                           </div>

                                       </div>

                                       <div class="row">
                                           <div class="col-md-6">
                                               <div class="wsus__check_single_form">
                                                   <input type="text" placeholder="State *" name="state"
                                                       value="{{ old('state') }}">
                                               </div>
                                           </div>


                                           <div class="col-md-6">
                                               <div class="wsus__check_single_form">
                                                   <input type="text" placeholder="Town \ City *" name="city"
                                                       value="{{ old('city') }}">
                                               </div>
                                           </div>

                                       </div>

                                       <div class="row">
                                           <div class="col-md-6">
                                               <div class="wsus__check_single_form">
                                                   <input type="text" placeholder="Address *" name="address"
                                                       value="{{ old('address') }}">
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="wsus__check_single_form">
                                                   <input type="text" placeholder="Zip Code *" name="zip"
                                                       value="{{ old('zip') }}">
                                               </div>
                                           </div>
                                       </div>

                                       <div class="col-xl-12">
                                           <div class="wsus__check_single_form">
                                               <button type="submit" class="btn btn-primary">Save</button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!--============================
            CHECK OUT PAGE END
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

               $('.shipping-method').on('click', function() {
                   let shippingFee = $(this).data('id');
                   let currentTotalAmount = $('#total_amount').data('id');
                   let totalAmount = (currentTotalAmount + shippingFee).toFixed(
                   2); // toFixed(2) function use for take from total amount just two number after cuma


                   $('#shipping_method_id').val($(this).val());
                   $('#shipping-fee').text("{{ $settings->currency_icon }}" + shippingFee);
                   $('#total_amount').text("{{ $settings->currency_icon }}" + totalAmount);

               });

               $('.shipping_address').on('click', function() {
                   $('#shipping_address_id').val($(this).data('id'));
               });


               $('#submitCheckoutForm').on('click', function(e) {
                   e.preventDefault();

                   if ($('#shipping_method_id').val() == "") {
                       toastr.error('Shipping Method is required !');
                   } else if ($('#shipping_address_id').val() == "") {
                       toastr.error('Shipping Address is required !');
                   } else if (!$('.agree_term').prop('checked')) {
                       toastr.error('you must be agree to this website terms and conditions !');
                   } else {
                       $.ajax({
                           method: 'POST',
                           url: "{{ route('user.checkout.submit') }}",
                           data: $("#checkOutForm").serialize(),
                           beforeSend: function() {
                               //spin reload 
                               $('#submitCheckoutForm').html(
                                   '<i class="fas fa-spinner fa-spin fa-1x"></i>')
                           },
                           success: function(data) {
                               if (data.status == "success") {

                                   $('#submitCheckoutForm').html('Place Order')
                                   /**  after checkout , we go to payment page */
                                   window.location.href = data.redirect_url;
                               }
                           },
                           error: function(data) {}
                       });
                   }

               });
           });
       </script>
   @endpush
