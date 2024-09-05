@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Admin Order "}}
@endsection



@section('content')


    <section class="section">
        <div class="section-header">
            <h1>Manage Orders</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Orders</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 ">
                {{-- <div class="container"> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>All Orders</h4>
                            <div class="card-header-action">
                                <a href="{{route('admin.order.trashed-orders')}}" class="btn btn-danger" > <i class="fas fa-dumpster"></i> Trashed Orders</a>
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
                        url: '{{route("admin.order.change-status")}}',
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