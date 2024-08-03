@extends('Admin.Dashboard.layouts.master')

@section('content')


    <section class="section">
        <div class="section-header">
        <h1>Manage Products Variant</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item">Product Variant</div>
        </div>
        </div>


        <div class="section-body">
            <div class="row">
                    

            </div>
            <div class="row">
                <div class="col-12 ">
                
                    <a href="{{route('admin.product.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                    <div class="card">
                        
                        
                        <div class="card-header">

                            <h4>Variant Of {{$product->name}} </h4>

                            <div class="card-header-action">
                                <a href="{{route('admin.product-variant.create',['product_id' => request()->id])}}" class="btn btn-primary" > <i class="fas fa-plus"></i> Create New</a>
                                {{-- <a href="{{route('admin.product-variant.create',['id'=>$product->id])}}" class="btn btn-primary" > <i class="fas fa-plus"></i> Create New</a> --}}
                            </div>
                        </div>

                        
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                
                    </div>
                </div>

            </div>

        </div>
    </section>
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
                        url: '{{route("admin.product-variant.change-status")}}',
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