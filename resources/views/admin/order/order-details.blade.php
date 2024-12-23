@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Order Details" }}
@endsection



@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.order.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Manage Orders</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Orders</a></div>
                <div class="breadcrumb-item">Order Details</div>
            </div>
        </div>

        <div class="section-body">
            {{-- <a href="{{ route('admin.order.index') }}" class="btn btn-primary"> <i class="fas fa-chevron-circle-left"></i>
                Back</a>
            <br><br> --}}

            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order #{{ $order->invoice_id }}</div>
                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-md-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        <b>- Name : </b> {{ $order_address->name }} <br>
                                        <b>- Email : </b> {{ $order_address->email }} <br>
                                        <b>- Phone : </b> {{ $order_address->phone }} <br>
                                        <b>- Address : </b> {{ $order_address->address }} <br>
                                        <b>- City : </b>{{ $order_address->city }} , <b>State :
                                        </b>{{ $order_address->state }} , <b>Zip : </b>{{ $order_address->zip }} <br>
                                        <b>- Country : </b> {{ $order_address->country }} <br>
                                    </address>
                                </div>

                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        {{ $order_address->name }} <br>
                                        {{ $order_address->email }} <br>
                                        {{ $order_address->phone }} <br>
                                        {{ $order_address->address }} <br>
                                        {{ $order_address->city }} , {{ $order_address->state }} ,
                                        {{ $order_address->zip }} <br>
                                        {{ $order_address->country }} <br>
                                    </address>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Payment Information:</strong><br>
                                        <b>- Payment Method : </b> {{ $order->payment_method }} <br>
                                        <b>- Transaction Id : </b> {{ @$order->transaction->transaction_id }} <br>
                                        <b>- Payment Status : </b>
                                        {{ $order->payment_status == 1 ? 'Complete' : 'Pending' }} <br>

                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{ date('F d,Y', strtotime($order->created_at)) }}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Products</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Variants</th>
                                        <th>Vendor Name</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>
                                    @if (isset($order->orderProducts) && count($order->orderProducts)>0)
                                        
                                        @foreach ($order->orderProducts as $product)
                                            <tr>
                                                @php
                                                    $variants = json_decode($product->variants);
                                                @endphp


                                                <td>{{ ++$loop->index }}</td>

                                                <td>
                                                    @if (isset($product->product->slug))
                                                        <a target="_blank"
                                                            href="{{ route('product-details', [$product->product->slug]) }}">
                                                            {{ $product->product_name }}
                                                        </a>
                                                    @else
                                                        {{ $product->product_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($variants))
                                                        @foreach ($variants as $key => $variant)
                                                            {{ $key }} : {{ $variant->name }}
                                                            ({{ $settings->currency_icon }}{{ $variant->price }})
                                                        @endforeach
                                                    @else
                                                        /
                                                    @endif
                                                </td>
                                                <td>{{ $product->vendor->shop_name }}</td>
                                                <td class="text-center">
                                                    {{ $settings->currency_icon }}{{ $product->unit_price }}</td>
                                                <td class="text-center">{{ $product->qty }}</td>
                                                <td class="text-right">
                                                    {{ $settings->currency_icon }}{{ ($product->unit_price + $product->variant_total) * $product->qty }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>

                            <div class="row mt-4">

                                {{-- <div class="col-lg-8">
                                    <div class="section-title">Payment Method</div>
                                    <p class="section-lead">The payment method that we provide is to make it easier for you to pay invoices.</p>
                                    <div class="images">
                                        <img src="{{asset('backend/assets/img/visa.png')}}" alt="visa">
                                        <img src="{{asset('backend/assets/img/jcb.png')}}" alt="jcb">
                                        <img src="{{asset('backend/assets/img/mastercard.png')}}" alt="mastercard">
                                        <img src="{{asset('backend/assets/img/paypal.png')}}" alt="paypal">
                                    </div>
                                </div> --}}

                                <div class="col-lg-8">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Payment Status</label>
                                            <select class="form-control" name="payment_status" id="payment_status"
                                                data-id="{{ $order->id }}">

                                                <option {{ $order->payment_status == 0 ? 'selected' : '' }} value="0">
                                                    Pending </option>
                                                <option {{ $order->payment_status == 1 ? 'selected' : '' }} value="1">
                                                    Complete </option>

                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Order Status</label>
                                            <select class="form-control" name="order_status" id="order_status"
                                                data-id="{{ $order->id }}">
                                                @foreach (Config('order_status.order_status_admin') as $key => $order_status)
                                                    <option {{ $order->order_status == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">{{ $order_status['status'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">
                                            {{ @$settings->currency_icon }}{{ $order->sub_total }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Shipping (+)</div>
                                        <div class="invoice-detail-value">
                                            {{ @$settings->currency_icon }}{{ @$shipping_method->cost }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Coupon
                                            (-{{ @$coupon->discount_percentage ? @$coupon->discount_percentage . '%' : '' }})
                                        </div>
                                        <div class="invoice-detail-value">
                                            {{ @$settings->currency_icon }}{{ @$coupon->discount ? @$coupon->discount : 0 }}
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ @$settings->currency_icon }}{{ $order->amount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">

                    <button class="btn btn-warning btn-icon icon-left print-order-details"><i class="fas fa-print"></i>
                        Print</button>
                </div>
            </div>

        </div>

    </section>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            //  <!-- Change Order Status ajax : -->
            $('#order_status').on('change', function() {
                let status = $(this).val();
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.order.change-order-status') }}',
                    method: 'GET',
                    data: {
                        status: status,
                        id: id
                    },
                    success: function(data) {

                        if (data.status == 'success') {
                            toastr.success(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error');
                    }
                });
            });
            // <!-- Change Payment Status ajax : -->
            $('#payment_status').on('change', function() {

                let status = $(this).val();
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.order.change-payment-status') }}',
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                            'content'), // Include the CSRF token in the data
                        status: status,
                        id: id
                    },
                    success: function(data) {
                        // Note the change to toastr.success instead of toastr().success
                        if (data.status == 'success') {
                            toastr.success(data.message);
                        } else if (data.status == 'error') {
                            toastr.warning(data.message);

                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error');
                    }
                });
            });

            //<!-- Print The invoice Details ajax : -->
            $('.print-order-details').on('click', function() {
                let printBody = $('.invoice-print');
                let originContent = $('body').html();

                $('body').html(printBody.html());

                window.print();

                $('body').html(originContent);

            });


        });
    </script>
@endpush
