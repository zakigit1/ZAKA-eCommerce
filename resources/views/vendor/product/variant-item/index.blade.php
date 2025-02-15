@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Product Variant Items"}}
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i> Products Variant Items</h3>
                <div class="back_button">
                    <a href="{{route('vendor.product-variant.index',['id'=>request()->productId])}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                </div>
                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        <h4>Variant : <code>{{$variant->name}}</code> </h4>

                        <div class="create_button">
                            <a href="{{route('vendor.product-variant-item.create',[$product->id,$variant->id])}}" class="btn btn-primary" > <i class="fas fa-plus"></i> Create New</a>
                        </div>
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

        <!-- Change Status ajax : -->
        <script>
            $(document).ready(function(){
                $('body').on('click', '.change-status', function(){
                    let isChecked = $(this).is(':checked');
                    let id = $(this).data('id');
    
                    $.ajax({
                        url: '{{route("vendor.product-variant-item.change-status")}}',
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), // Include the CSRF token in the data
                            status: isChecked,
                            id: id
                        },
                        success: function(data){
                           // Note the change to toastr.success instead of toastr().success
                            if (data.status == 'success') {
                                toastr.success(data.message);
                            }else if(data.status == 'error'){ 
                                toastr.warning(data.message);
                               
                                setTimeout(function(){
                                    window.location.reload();
                                }, 3000);        
                            }
                        },
                        error: function(xhr, status, error){
                            console.log('error');
                        }
                    });
                });
            });
        </script>
    
@endpush