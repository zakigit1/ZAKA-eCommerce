@extends('Frontend.store.layouts.master')

@section('title', "$settings->site_name || Wishlist")

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
                            <table>
                                <tbody>
                                    @if(isset($wishlists) && count($wishlists) > 0)

                                        <tr class="d-flex">
                                            <th class="wsus__pro_img" style="width: 12.5%">
                                                product item
                                            </th>

                                            <th class="wsus__pro_name" style="width: 25%">
                                                product name
                                            </th>

                                            <th class="wsus__pro_status" style="width: 25%">
                                                status
                                            </th>

                                            <th class="wsus__pro_tk" style="width: 25%">
                                                price
                                            </th>

                                            <th class="wsus__pro_icon" style="width: 12.5%">
                                                action
                                            </th>
                                        </tr>

                                    
                                        @foreach ($wishlists as $wishlist)
                                            {{-- @php
                                                $product = \App\Models\Product::where('id', $wishlist->product_id)->first();

                                            @endphp --}}


                                            <tr class="d-flex">
                                                <td class="wsus__pro_img" style="width: 12.5%" >
                                                    <img src="{{ $wishlist->product->thumb_image }}"
                                                        alt="{{ $wishlist->product->name }}" class="img-fluid w-100">
                                                    <a href="{{route('user.wishlist.destroy',['wishlist_id' => $wishlist->id])}}"><i class="far fa-times"></i></a>
                                                </td>

                                                <td class="wsus__pro_name" style="width: 25%">
                                                    <a href="{{ route('product-details', $wishlist->product->slug) }}">{{ limitText($wishlist->product->name) }}</a>
                                                </td>


                                                
                                                <td class="wsus__pro_status" style="width: 25%">
                                                    @if ($wishlist->product->qty > 0)
                                                        <p>in stock </p>
                                                    @else
                                                        <p><span>out of stock</span></p>
                                                    @endif
                                                </td>

                                                <td class="wsus__pro_tk" style="width: 25%">
                                                    <!-- Start check if there is discount or not -->
                                                    @if (check_discount($wishlist->product))
                                                        <h6 >{{ $settings->currency_icon }}
                                                            {{ $wishlist->product->offer_price }}</h6>
                                                    @else
                                                        <h6>{{ $settings->currency_icon }}
                                                            {{ $wishlist->product->price }}</h6>
                                                    @endif
                                                    <!-- End check if there is discount or not -->
                                                </td>


                                                <td class="wsus__pro_icon" style="width: 12.5%">
                                                    <form class="shopping-cart-form">

                                                        <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                    
                                                    
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
                                                        
                    
                    
                                                        <input type="hidden" min="1" max="100" value="1" name="qty" />
                    
                    
                                                        <ul class="wsus__button_area">

                                                            <li><button type="submit" class="add_cart" href="#">add to cart</button></li>
                                                        </ul>   
                                                    </form>

                                                </td>

                                            </tr>


                                        @endforeach
                                    @else

                                        <tr class="d-flex">
                                            <th class="wsus__pro_img" >
                                                product item
                                            </th>

                                            <th class="wsus__pro_name" >
                                                product name
                                            </th>

                                            <th class="wsus__pro_status" >
                                                status
                                            </th>

                                            <th class="wsus__pro_tk">
                                                price
                                            </th>

                                            <th class="wsus__pro_icon" >
                                                
                                            </th>
                                            <th class="wsus__pro_icon" >
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
