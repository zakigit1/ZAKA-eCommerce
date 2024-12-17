@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Vendor Create Withdraw Request "}}
@endsection

@section('content')





    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <div class="back_button">
                    <a href="{{route('vendor.withdraw.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> back</a>
                </div>
                <br>
                <h3><i class="far fa-user"></i> Withdrow Request Information  </h3>
                

                
                
                <div class="wsus__dashboard_profile">
                    <div class="row">
                    
                            <div class="wsus__dash_pro_area">
                       
                                <div class="row">
                                   
                                  
                                    <div class="table-responsive">
                                        {{-- <table class="table table-striped table-hover table-md"> --}}
                                        <div class="d-flex justify-content-center">
                                            <table style="width: 1100px" class="table table-bordered">
                                                <tr>
                                                    <th style="width: 30%">Withdraw Method </th>
                                                    <td>{{$withdrawRequest->method->name}}</td>
                                                </tr>

                                                <tr>
                                                    <th style="width: 30%">Withdraw Charge {{-- رسوم السحب--}} </th>
                                                    <td>{{(($withdrawRequest->withdraw_charge / $withdrawRequest->total_amount) * 100) }} %</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%">Withdraw Charge Amount {{--مبلغ رسوم السحب--}}</th>
                                                    <td>{{$settings->currency_icon.$withdrawRequest->withdraw_charge}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%">Total Amount {{--المبلغ الإجمالي--}} </th>
                                                    <td>{{$settings->currency_icon.$withdrawRequest->total_amount}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%">Withdraw Amount {{--المبلغ الذي يمكن سحبه بعد أخد الرسوم السحب--}}</th>
                                                    <td>{{$settings->currency_icon.$withdrawRequest->withdraw_amount}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th style="width: 30%">Your Request Status </th>
                                                    <td>
                                                        @if($withdrawRequest->status == 'paid')
        
                                                            <span class="badge bg-success">Paid</span>
        
                                                        @elseif($withdrawRequest->status == 'pending')
        
                                                            <span class="badge bg-warning">Pending</span>
        
                                                        @elseif($withdrawRequest->status == 'decline')
        
                                                            <span class="badge bg-danger">decline</span>
                                                        
                                                        @endif
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%">Your Information </th>
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
    </div>
@endsection

