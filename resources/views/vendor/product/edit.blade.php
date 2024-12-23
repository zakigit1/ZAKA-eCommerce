@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{ @$settings->site_name ." || Edit Product "}}
@endsection



@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <div class="back_button">
                    <a href="{{route('vendor.product.index')}}" class="btn btn-primary" ><i class="fas fa-chevron-circle-left"></i>  Back</a>
                </div>
                <br>
                <h3><i class="far fa-user"></i>Edit Product</h3>

                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        
                            
                            
                                <form action="{{route('vendor.product.update',$product->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group wsus__input">
                                        <label >Preview </label><br>
                                        <img  width="200px" src="{{$product->thumb_image}}" alt="product-thumb-img">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="image">Image</label>
                                        <input type="file" name="thumb_image" class="form-control"  placeholder="Thumb Image" >
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="">Product Name</label>
                                        <input type="text" name="name" class="form-control" id="" placeholder="Product Name" value="{{$product->name}}">
                                    </div>
        
        
                                    <div class="row ">
        
                                        <div class="col-md-4">
                                            <div class="form-group wsus__input">
                                                <label >Categories</label>
                                                <select class="form-control main-category"  name="category">
                                                
                                                    @foreach ($categories as $category)
                                                    <option  value="{{$category->id}}" {{($category->id == $product->category_id ) ? 'selected' : ''}} >{{$category->name}}</option>
                                                    @endforeach
                                                
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-md-4">
                                            <div class="form-group wsus__input">
                                                <label >Sub Categories</label>
                                                <select class="form-control sub-category"  name="subcategory">
                                                
                                                    
                                                    <option selected value="">None</option>
                                                    @foreach ($subcategories as $subcategory)
                                                        <option value="{{$subcategory->id}}" {{($subcategory->id == $product->sub_category_id ) ? 'selected' : ''}}>{{$subcategory->name}}</option>
                                                    @endforeach
        
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-md-4">
                                            <div class="form-group wsus__input">
                                                <label >Child Categories</label>
                                                <select class="form-control child-category"  name="childcategory">
                                                
                                                    
                                                    <option selected value="">None</option>
                                                    @foreach ($childcategories as $childcategory)
                                                        <option value="{{$childcategory->id}}" {{($childcategory->id == $product->child_category_id ) ? 'selected' : ''}}>{{$childcategory->name}}</option>
                                                    @endforeach
        
                                                </select>
                                            </div> 
                                        </div> 
        
                                    </div>
        
                                        
                                    <div class="form-group wsus__input">
                                        <label >Brands</label>
                                            <select class="form-control mt-6"  name="brand">
                                            
                                                @foreach ($brands as $brand)
                                                    <option value="{{$brand->id}}" {{($brand->id == $product->brand_id ) ? 'selected' : ''}}>{{$brand->name}}</option>
                                                @endforeach
                                            
                                            </select>
                                    </div>
        
        
                                    <div class="form-group wsus__input">
                                        <label for="">SKU</label>
                                        <input type="text" name="sku" class="form-control" id="" placeholder="SKU" value="{{$product->sku}}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control" id="" placeholder="Price" value="{{$product->price}}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="">Offer Price</label>
                                        <input type="text" name="offer_price" class="form-control" id="" placeholder="Price" value="{{$product->offer_price}}">
                                    </div>
        
        
                                    <div class="row">
        
                                        <div class="col-md-6">
                                            <div class="form-group wsus__input">
                                                <label >Offer Start Date</label>
                                                <input type="text" name="offer_start_date" class="form-control datepicker" value="{{$product->offer_start_date}}">
                                                {{-- <input type="text" name="offer_start_date" class="form-control datepicker" value="{{ Carbon\Carbon::now()}}"> --}}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group wsus__input">
                                                <label >Offer End Date</label>
                                                <input type="text" name="offer_end_date" class="form-control datepicker" value="{{$product->offer_end_date}}">
                                            </div>  
                                        </div>
        
                                    </div>
        
                                    <div class="form-group wsus__input">
                                        <label for="">Stock Quantity</label>
                                        <input type="number" min="0" name="qty" class="form-control" id="" placeholder="Stock Quantity" value="{{$product->qty}}">
                                    </div>
        
                                    <div class="form-group wsus__input">
                                        <label for="btn_url">Product Video</label>
                                        <input type="text" name="video_link" class="form-control" id="btn_url" placeholder="Video Link" value="{{$product->video_link}}">
                                    </div>
        
                                    <div class="form-group wsus__input">
                                        <label for="">Short Description</label>
                                       <textarea name="short_description" class="form-control" id="" cols="30" rows>{!! $product->short_description !!}</textarea>
                                    </div>
        
                                    <div class="form-group wsus__input">
                                        <label for="">Long Description</label>
                                        <textarea name="long_description" class="form-control summernote" id="" cols="30" rows>{!! $product->long_description !!}</textarea>
                                    </div>
        
        
                                    
        

        
        
                                    <div class="form-group wsus__input">
                                        
                                        <label >Seo Title</label>
                                        <input type="text" name="seo_title" class="form-control" value="{{$product->seo_title}}">
                                        
                                    </div>
                                    <div class="form-group wsus__input">
                                        
                                        <label >Seo Description</label>
                                        <textarea name="seo_description" class="form-control" rows="3">{!! $product->seo_description !!}</textarea>
                                        
                                    </div>
                                    
        
        
        
                                    <div class="form-group wsus__input">
                                        <label for="inputStatus">Status</label>
                                        <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                            
                                            <option @if($product->status == 1) selected @endif value="1">active</option>
                                            <option {{($product->status == 0) ? 'selected' : '' }} value="0">inactive</option>
                                            
                                        </select>
                                    </div>
                                    
        
                                    <input type="submit" class="btn btn-primary " name="submit" value="Update">
        
        
                                </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

















@push('scripts')
   <script>
        $(document).ready(function(){

            //              get sub categories : 

            $('body').on('change', '.main-category', function(e){

                //this line to reset the child-categories when you change the category  
                // $('.child-category').html('<option selected disabled>Select</option>');

                let id = $(this).val();

                $.ajax({
                    method: 'GET',
                    url: '{{route("vendor.product.get-sub-categories")}}',
                    data: {
                        category_id: id,
                    },
                    success: function(data){
                        //this line to reset the sub-categories when you change the category 
                        $('.sub-category').html('<option selected value="">Select</option>');

                        //this line to reset the child-categories when you change the category 
                        $('.child-category').html('<option selected value="">Select</option>');

                        $.each(data, function(i, item) {
                            // $('.sub-category').append('<option value="'+item.id+'">'+item.name+'</option>');
                        
                            $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error){
                        console.log('error');
                    }
                });
            });

            //              get child categories : 

            $('body').on('change', '.sub-category', function(e){
                
                let id = $(this).val();

                $.ajax({
                    method: 'GET',
                    url: '{{route("vendor.product.get-child-categories")}}',
                    data: {
                        sub_category_id: id,
                    },
                    success: function(data){
                        $('.child-category').html('<option selected value="">Select</option>');

                        $.each(data, function(i, item) {
                        
                            $('.child-category').append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error){
                        console.log('error');
                    }
                });
            });
        });
    </script> 
@endpush