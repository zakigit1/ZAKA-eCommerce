@extends('Frontend.user.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || User Request To Be A Vendor "}}
@endsection



@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i> Request To Be A Vendor</h3>

                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        <div class="card">
                            
                            <div class="card-body">
                                {!! @$vendorCondition->content !!}
                            </div>
                        </div> 

                        <br>

                        <div class="card">
                            
                            <div class="card-body">
                                <div class="row">
                                    <h4>User Vendor information</h4>
                                    <form action="{{route('user.vendor-request.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                            <div class="mt-4 mb-2">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fal fa-image"></i>
                                                    <input type="file" name="banner">
                                                
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-5">
                                                <div class="col-md-5 ">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-user-tie"></i>
                                                        <input type="text" placeholder="Shop Name" name="shop_name">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-7">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fal fa-envelope-open"></i>
                                                        <input type="email" placeholder="Shop Email" name="shop_email">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-md-5 ">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-phone"></i>
                                                    
                                                        <input type="tel" placeholder="Shop Phone" name="shop_phone">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-7">
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <input type="text" placeholder="Shop Address" name="shop_address">
                                                    </div>
                                                </div>
                                            </div>

                                        
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-info-circle"></i>
                                                <textarea class="mt-4" name="about" placeholder="About You"></textarea>
                                            </div>



                                        <div class="col-xl-12">
                                            <button class="common_btn mb-4 mt-2" type="submit">Submit</button>
                                        </div>
                                    </form>

                                </div>


                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush