@extends('Frontend.user.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || User Orders "}}
@endsection



@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="fas fa-clipboard-list-check"></i>Manage User Orders</h3>

                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        <div class="card">
                            
                            <div class="card-body">
                                {{ $dataTable->table() }}
                            </div>
                    
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

 
@endpush