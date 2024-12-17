@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Vendor Create Withdraw Request "}}
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <div class="back_button">
                    <a href="{{route('vendor.withdraw.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                </div>
                <br>


                <h3><i class="far fa-user"></i> Vendor Create Withdraw Request </h3>
                <div class="wsus__dashboard_profile">
                    <div class="row">
                        
                            <div class="wsus__dash_pro_area col-md-7">
                       
                                <div class="row">
                                    
                                    <form action="{{route('vendor.withdraw.store')}}" method="post">
                                        @csrf
            
                                        <div class="form-group wsus__input">
                                            <label><b>Withdraw Method :</b></label>
                                            <select class="form-control mt-6" id="withdraw_method" class="form-control" name="withdraw_method_id">
                                            
                                                <option selected disabled>-- Select --</option>
        
                                                @foreach ($withdrowMethods as $method)
                                                    <option value="{{$method->id}}">{{$method->name}}</option>
                                                @endforeach
                                            
                                            </select>
                                        </div>
        
        
                                        <div class="form-group wsus__input">
                                            <label><b>Total Amount :</b></label>
                                            <input type="text" name="total_amount" placeholder="Enter Total Amount" class="form-control" value="{{old('total_amount')}}">
                                        </div>
        
                                        <div class="form-group wsus__input">
                                            <label><b>Account Information :</b></label>
                                           <textarea name="account_information" id="" cols="30" rows="10">{{old('account_information')}}</textarea>
                                        </div>
        
        
                                        {{-- 
                                            <div class="form-group wsus__input">
                                                <label for="inputStatus">Status</label>
                                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                                    <option selected disabled>-- Select --</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="paid">Paid</option>
                                                    <option value="decline">Decline</option>
                                                </select>
                                            </div> 
                                        --}}
        
                                            <br>
                                        <input type="submit" class="btn btn-primary wsus__input" value="Create">
            
            
                                    </form>
                                                    
                                </div>
                            
                            </div>
        
                            <div class="wsus__dash_pro_area col-md-5 withrow_method_information">
                                <div class="row">                     
                                </div>
                            </div>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

<script>
    $(document).ready(function() {
        
        $('#withdraw_method').on('change',function(e){
                e.preventDefault();

                let id = $(this).val();
        
                $.ajax({
                    type: 'GET',
                    url: "{{ route('vendor.withdraw.withdraw-method-details',':id') }}".replace(':id',id),

                    success: function (data) {
                        if(data.status == 'error'){ 
                            toastr.warning(data.message); 
                        }

                        $('.withrow_method_information').html(`
                            <h3> Payout range : {{$settings->currency_icon}} ${data.withdrawMethod.minimum_amount} - {{$settings->currency_icon}} ${data.withdrawMethod.maximum_amount} </h3>
                            <h3> Withdraw charge : ${data.withdrawMethod.withdraw_charge} %</h3>
                            <p> ${data.withdrawMethod.description}</p>
                    
                        `)
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });
    });
</script>
@endpush