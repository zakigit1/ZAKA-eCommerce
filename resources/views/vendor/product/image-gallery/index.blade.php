@extends('vendor.Dashboard.layouts.master')


@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="fas fa-images"></i></i>Vendor Product gallery </h3>

                <div class="back_button">
                    <a href="{{route('vendor.product.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a><br>
                </div>

                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        <div class="card">
                            <div class="card-body">
                                <h4>{{$product->name}} gallery</h4>
                            </div>
    
                            <div class="card-body">
                                <form action="{{route('vendor.product-image-gallery.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    
                                    <div class="form-group wsus__input">    
                                        <label> Upload Image <code>(multiple image supported!!)</code></label> <br>
                                        <input type="file" name="image[]" multiple>
                                    </div>
    
                                    <button class="btn btn-primary" type="submit" >Upload</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="wsus__dashboard_profile mt-5">
                    <div class="wsus__dash_pro_area">  

                        <div class="create_button">
                            <a class="btn btn-danger delete-item-with-ajax"  href="{{route("vendor.product-image-gallery.destroy-all-images",$product->id)}}"><i class="fas fa-trash-alt"></i> Delete Gallery </a>
                        </div>
                        <div class="card ">
                            <div class="card-body">
                                <h4>Gallery Of {{$product->name}} </h4>
                            </div>

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