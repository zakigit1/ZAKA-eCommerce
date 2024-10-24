@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Vendor Create Withdraw Request "}}
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i> Vendor Create Withdraw Request </h3>
                
                <div class="back_button">
                    <a href="{{route('vendor.withdraw.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> back</a>
                </div>
                
                <div class="wsus__dashboard_profile">
                    <div class="row">
                        
                            <div class="wsus__dash_pro_area ">
                       
                                <div class="row">
                                    <h3>Withdrow Request Information :</h3>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
        
        
                                            <tr>
                                                <th>Withdraw Method Name </th>
                                                <td>{{$withdrawRequest->method->name}}</td>
                                            </tr>

                                            <tr>
                                                <th>Withdraw Charge :</th>
                                                <td>{{$withdrawRequest->withdraw_charge}} %</td>
                                            </tr>
                                            <tr>
                                                <th>Total Amount :</th>
                                                <td>{{$settings->currency_icon.$withdrawRequest->total_amount}}</td>
                                            </tr>
                                            <tr>
                                                <th>Withdraw Amount :</th>
                                                <td>{{$settings->currency_icon.$withdrawRequest->withdraw_amount}}</td>
                                            </tr>

                                            <tr>
                                                <th>Your Information:</th>
                                                <td>{!! $withdrawRequest->account_information !!}</td>
                                            </tr>
         
         
                                        </table>
                                    </div>
                                                    
                                </div>
                            
                            </div>
        

                        
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

