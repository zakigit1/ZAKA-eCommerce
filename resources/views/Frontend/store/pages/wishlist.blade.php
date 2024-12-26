@extends('Frontend.store.layouts.master')

@section('title', @$settings->site_name . ' Wishlist')

@section('content')

    <!--============================
                                BREADCRUMB START
                            ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Wishlist</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:;">Wishlist</a></li>
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
                <div class="col-12">
                    <div class="wsus__cart_list wishlist">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @if (isset($wishlists) && count($wishlists) > 0)
                                        <tr class="d-flex">
                                            <th class="wsus__pro_img" style="width: 25%">
                                                product item
                                            </th>

                                            <th class="wsus__pro_name" style="width: 30%">
                                                product name
                                            </th>

                                            <th class="wsus__pro_status" style="width: 20%">
                                                status
                                            </th>

                                            <th class="wsus__pro_tk" style="width: 15%">
                                                price
                                            </th>

                                            <th class="wsus__pro_icon" style="width: 20%">
                                                action
                                            </th>
                                        </tr>
                                    

                                        @foreach ($wishlists as $wishlist)
                                            {{-- @php
                                                $product = \App\Models\Product::where('id', $wishlist->product_id)->first();

                                            @endphp --}}

                                            <tr class="d-flex wishlist-item" id="wishlist_details_{{ $wishlist->id }}">
                                                <td class="wsus__pro_img" style="width: 20% ">
                                                    <img  style="width: 80% !important;
                                                    height: 100px !important;
                                                    object-fit: cover;"
                                                     src="{{ $wishlist->product->thumb_image }}"
                                                        alt="{{ $wishlist->product->name }}" class="img-fluid w-100">
                                                    {{-- <a
                                                        href="{{ route('user.wishlist.destroy', ['wishlist_id' => $wishlist->id]) }}"><i
                                                            class="far fa-times"></i></a> --}}
                                                    <a class="remove-product-wishlist" 
                                                        data-url-product-wishlist="{{route('user.wishlist.destroy',$wishlist->id)}}">
                                                        <i class="far fa-times"></i></a>
                                                </td>

                                                <td class="wsus__pro_name" style="width: 30% ; margin-left: 30px">
                                                    <a
                                                        href="{{ route('product-details', $wishlist->product->slug) }}">{{ limitText($wishlist->product->name) }}</a>
                                                </td>



                                                <td class="wsus__pro_status" style="width: 20%">
                                                    @if ($wishlist->product->qty > 0)
                                                        <p>in stock </p>
                                                    @else
                                                        <p><span>out of stock</span></p>
                                                    @endif
                                                </td>

                                                <td class="wsus__pro_tk" style="width: 12%">
                                                    <!-- Start check if there is discount or not -->
                                                    @if (check_discount($wishlist->product))
                                                        <h6>{{ $settings->currency_icon }}
                                                            {{ $wishlist->product->offer_price }}</h6>
                                                    @else
                                                        <h6>{{ $settings->currency_icon }}
                                                            {{ $wishlist->product->price }}</h6>
                                                    @endif
                                                    <!-- End check if there is discount or not -->
                                                </td>


                                                <td class="wsus__pro_icon" style="width: 20%">
                                                    <form class="shopping-cart-form">

                                                        <input type="hidden" name="product_id"
                                                            value="{{ $wishlist->product->id }}">


                                                        @foreach ($wishlist->product->variants as $variant)
                                                            <select class="d-none" name="variant_items[]">
                                                                @foreach ($variant->items as $item)
                                                                    <option {{ $item->is_default == 1 ? 'selected' : '' }}
                                                                        value="{{ $item->id }}"> {{ $item->name }}
                                                                        {{ $item->price > 0 ? '(' . $settings->currency_icon . ' ' . $item->price . ')' : '' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @endforeach



                                                        <input type="hidden" min="1" max="100" value="1"
                                                            name="qty" />


                                                        <ul class="wsus__button_area">

                                                            <li><button type="submit" class="add_cart" href="#">add
                                                                    to cart</button></li>
                                                        </ul>
                                                    </form>

                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="d-flex">
                                            <th class="wsus__pro_img">
                                                product item
                                            </th>

                                            <th class="wsus__pro_name">
                                                product name
                                            </th>

                                            <th class="wsus__pro_status">
                                                status
                                            </th>

                                            <th class="wsus__pro_tk">
                                                price
                                            </th>

                                            <th class="wsus__pro_icon">

                                            </th>
                                            <th class="wsus__pro_icon">
                                                action
                                            </th>
                                        </tr>

                                        <tr class="d-flex">
                                            <td class="wsus__pro_icon" rowspan="2" style="width: 100%">
                                                The Wishlist Is Empty !
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
            /** remove product from the cart (AJAX Request no-reload):  */
            $('body').on('click', '.remove-product-wishlist', function() {

                $.ajax({
                    url: $(this).attr('data-url-product-wishlist'),
                    type: 'get',

                    success: function(data) {

                        if (data.status == 'success') {

                            let wishlilstId = "#wishlist_details_" + data.wishlist_id;
                            $(wishlilstId).remove()
                           
                            $('#wishlist_count').text(data.count)

                            if ($(".wishlist-item").length == 0) {
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
        });
    </script>
@endpush
