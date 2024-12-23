@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ @$settings->site_name ." || Edit Shipping Rule " }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.shipping-rules.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Edit Shipping Rule</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.shipping-rules.index') }}">Shipping Rule</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    {{-- <a href="{{ route('admin.shipping-rules.index') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4> Edit Shipping Rule</h4>

                        </div>
                        <div class="card-body">

                            <form action="{{ route('admin.shipping-rules.update', $shippingRule->id) }}" method="post">

                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label>Shipping Rule Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Coupon Name"
                                        value="{{ $shippingRule->name }}">
                                </div>

                                <div class="form-group ">
                                    <label>Type</label>
                                    <select class="form-control shipping-type" name="type">
                                        <option selected disabled>-- Select --</option>
                                        <option {{ $shippingRule->type == 'flat_cost' ? 'selected' : '' }}
                                            value="flat_cost">Flat Cost</option>
                                        <option {{ $shippingRule->type == 'min_cost' ? 'selected' : '' }}
                                            value="min_cost">Minimum Order Amount</option>
                                    </select>
                                </div>


                                <div class="form-group min-cost d-none">
                                    <label> Minimum Amount</label>
                                    <input type="text" name="min_cost" class="form-control" placeholder="Minimum Amount"
                                        value="{{ $shippingRule->min_cost }}">
                                </div>
                                <div class="form-group">
                                    <label> Cost </label>
                                    <input type="text" name="cost" class="form-control" placeholder="Cost"
                                        value="{{ $shippingRule->cost }}">
                                </div>



                                <div class="form-group ">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option selected disabled>-- Select --</option>
                                        <option {{ $shippingRule->status == 1 ? 'selected' : '' }} value="1">active
                                        </option>
                                        <option {{ $shippingRule->status == 0 ? 'selected' : '' }} value="0">
                                            inactive</option>
                                    </select>
                                </div>


                                <input type="submit" class="btn btn-primary" value="Update">

                            </form>

                        </div>
                    </div>

                </div>
            </div>
    </section>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('body').on('change', '.shipping-type', function() {
                let value = $(this).val();

                if (value != 'min_cost') {
                    $('.min-cost').addClass('d-none');
                } else {
                    $('.min-cost').removeClass('d-none');
                }

            })
        })
    </script>
@endpush
