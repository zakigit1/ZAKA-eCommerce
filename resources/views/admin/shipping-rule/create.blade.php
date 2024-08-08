@extends('Admin.Dashboard.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Add Shipping Rule</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.coupons.index')}}">Shipping Rule</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <a href="{{route('admin.shipping-rules.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                    <div class="card">
                        <div class="card-header">
                            <h4> Create Shipping Rule</h4>
                        
                        </div>
                        <div class="card-body">
                            
                            <form action="{{route('admin.shipping-rules.store')}}" method="post">

                                @csrf

                                <div class="form-group">
                                    <label>Shipping Rule Name</label>
                                    <input type="text" name="name" class="form-control"  placeholder="Shipping Rule Name" value="{{old('name')}}">
                                </div>

                                <div class="form-group ">
                                    <label >Type</label>
                                    <select class="form-control shipping-type" name="type">
                                        <option selected disabled>-- Select --</option>
                                        <option value="flat_cost">Flat Cost</option>
                                        <option value="min_cost">Minimum Order Amount</option>
                                    </select>
                                </div>


                                <div class="form-group min-cost d-none">
                                    <label> Minimum Amount</label>
                                    <input type="text" name="min_cost" class="form-control"  placeholder="Minimum Amount" value="{{old('min_cost')}}">
                                </div>

                                <div class="form-group">
                                    <label> Cost </label>
                                    <input type="text" name="cost" class="form-control"  placeholder="Cost" value="{{old('cost')}}">
                                </div>



                                <div class="form-group ">
                                    <label >Status</label>
                                    <select class="form-control"  name="status">
                                        <option selected disabled>-- Select --</option>
                                        <option value="1">active</option>
                                        <option value="0">inactive</option>
                                    </select>
                                </div>
                                

                                <input type="submit" class="btn btn-primary"  value="Create">

                            </form>
                        
                        </div>
                    </div>

            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        $(document).ready(function(){
            $('body').on('change', '.shipping-type', function(){
                    let value = $(this).val();

                if(value != 'min_cost'){
                    $('.min-cost').addClass('d-none');
                }else{
                    $('.min-cost').removeClass('d-none');
                }

            })
        })
    </script>
    
@endpush