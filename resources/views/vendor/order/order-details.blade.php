@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Vendor Order Details"}}
@endsection



@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i>Order Details</h3>
                

                <div class="back_button">
                    <a href="{{route('vendor.order.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                </div>

                <div class="wsus__dashboard_profile">
                
                    <!--============================
                        INVOICE PAGE START
                    ==============================-->
                    <section id="" class="invoice-print">
                        <div class="">
                            <div class="wsus__invoice_area">
                                <div class="wsus__invoice_header">
                                    <div class="wsus__invoice_content">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                <div class="wsus__invoice_single">
                                                    <h5>Bill To </h5>
                                                    <h6>{{$order_address->name}} </h6>
                                                    <p>{{$order_address->email}}</p>
                                                    <p>{{$order_address->phone}}</p>
                                                    <p>{{$order_address->address}} </p>
                                                    <p>{{$order_address->city}} ,{{$order_address->state}} ,{{$order_address->zip}} </p>
                                                    <p>{{$order_address->country}}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                <div class="wsus__invoice_single text-md-center">
                                                    <h5>Shipping Information</h5>
                                                    <h6>{{$order_address->name}} </h6>
                                                    <p>{{$order_address->email}}</p>
                                                    <p>{{$order_address->phone}}</p>
                                                    <p>{{$order_address->address}} </p>
                                                    <p>{{$order_address->city}} ,{{$order_address->state}} ,{{$order_address->zip}} </p>
                                                    <p>{{$order_address->country}}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="wsus__invoice_single text-md-end">
                                                    <h5>Order Id : #{{$order->invoice_id}}</h5>
                                                    <div class="order_st"><h6>Order Status : {{Config('order_status.order_status_admin')[$order->order_status]['status']}} </h6></div>
                                                    <p>Payment Method : {{$order->payment_method}} </p>
                                                    <p>Transaction Id : {{@$order->transaction->transaction_id}} </p>
                                                    <p>Payment Status : {{$order->payment_status == 1 ? 'Complete' : 'Pending'}} </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wsus__invoice_description">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th class="images">
                                                        image
                                                    </th>

                                                    <th class="name">
                                                        product
                                                    </th>
                                                    <th class="vendor_name">
                                                        Vendor Name
                                                    </th>

                                                    <th class="amount">
                                                        amount
                                                    </th>

                                                    <th class="quentity">
                                                        quentity
                                                    </th>
                                                    <th class="total">
                                                        total
                                                    </th>
                                                </tr>


                                                @foreach($order->orderProducts as $product)

                                                    <tr>

                                                        @php
                                                            $variants = json_decode($product->variants);

                                                            $total = 0;
                                                            $total+= ($product->unit_price + $product->variant_total ) * $product->qty ;
                                                        @endphp


                                                        <td class="images">
                                                            <img src="{{$product->product->thumb_image}}" alt="bag" class="img-fluid w-100">
                                                        </td>

                                                        <td class="name">
                                                            <p>                                    
                                                                @if(isset($product->product->slug))
                                                                    <a target="_blank" href="{{route('product-details',[$product->product->slug])}}">    
                                                                        {{$product->product_name}}
                                                                    </a>
                                                                @else
                                                                    {{$product->product_name}}
                                                                @endif
                                                            </p>
                                                            <span>
                                                                @if(!empty($variants))
                                                                    @foreach ($variants as $key=>$variant)
                                                                        {{$key}} : {{$variant->name}} ({{$settings->currency_icon}}{{$variant->price}})
                                                                    @endforeach
                                                                @else
                                                                
                                                                @endif
                                                            </span>

                                                        </td>
                                                        <td class="vendor_name">
                                                            {{$product->vendor->shop_name}}
                                                        </td>
                                                        <td class="amount">
                                                            {{$settings->currency_icon}}{{$product->unit_price}}
                                                        </td>

                                                        <td class="quentity">
                                                            {{$product->qty}}
                                                        </td>
                                                        <td class="total">
                                                            {{$settings->currency_icon}}{{($product->unit_price + $product->variant_total ) * $product->qty}}
                                                            {{-- {{ $settings->currency_icon }} {{ ($product->unit_price * $product->qty) + $product->variant_total }} --}}
                                                        </td>
                                                    </tr>



                                            </table>


                                        @endforeach


                                        </div>
                                    </div>
                                </div>

                                <div class="wsus__invoice_footer">
                                    <p><span><strong> Total Amount :</strong></span>{{$settings->currency_icon }}{{$total}} </p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--============================
                        INVOICE PAGE END
                    ==============================-->

                    @if (in_array($order->order_status, array_keys(Config('order_status.order_status_vendor'))))
                        <div class="col-md-4">
                            <div class="form-group mt-5">
                                <label class="mt-2"> Order Status : </label>
                                <select class="form-control" name="order_status" id="order_status" data-id="{{$order->id}}">
                                    @foreach (Config('order_status.order_status_vendor') as $key => $order_status)
                                        <option {{$order->order_status == $key ? 'selected' : '' }} value="{{$key}}">{{$order_status['status']}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    @else
                        <div class="col-md-4">
                            <div class="form-group mt-5">
                                <label class="mt-2"> Order Status : </label>
                                <select class="form-control" name="order_status" id="order_status" data-id="{{$order->id}}">
   
                                    <option selected disabled>{{Config('order_status.order_status_admin')[$order->order_status]['status']}}</option>
                                    
                                </select>

                            </div>
                        </div>
                    @endif



                    <hr>

                    <div style="text-align: right;">
                        <button class="btn btn-warning btn-icon icon-left print-order-details" ><i class="fas fa-print"></i> Print</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>





@endsection


@push('scripts')

    <script>
        $(document).ready(function(){
            //  <!-- Change Order Status ajax : -->
                $('#order_status').on('change', function(){
                    let status = $(this).val();
                    let id = $(this).data('id');
                    
                    const orderStatuses = @json(Config('order_status.order_status_vendor'));
                    
                    $.ajax({
                        url: '{{route("vendor.order.change-order-status")}}',
                        method: 'GET',
                        data: {
                            status: status,
                            id: id
                        },
                        success: function(data){
                           
                            if (data.status == 'success') {
                                const statusText = orderStatuses[status]['status'];
                                $('.order_st').html('<h6> Order Status : ' + statusText + '</h6>');

                                toastr.success(data.message);
                            }
                        },
                        error: function(xhr, status, error){
                            console.log('error');
                        }
                    });
                });
 
            
            //<!-- Print The invoice Details ajax : -->
                $('.print-order-details').on('click', function(){
                    let printBody = $('.invoice-print');
                    let originContent = $('body').html();

                    $('body').html(printBody.html());
                    
                    window.print();
                    
                    $('body').html(originContent);

                });

            
        });
    </script>

        


@endpush