@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Create Product Variant"}}
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <div class="back_button">
                    <a href="{{route('admin.product-variant.index',['id'=>request()->product_id])}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                </div>
                <br>
                <h3><i class="far fa-user"></i>Add New Variant</h3>
                

                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        

                        <form action="{{route('vendor.product-variant.store')}}" method="post">

                            @csrf

                            <input type="hidden" name="product_id" value="{{request()->product_id}}">

                            <div class="form-group wsus__input">
                                <label for="type">Variant Name</label>
                                <input type="text" name="name" class="form-control" id="" placeholder="Variant Name" value="{{old('name')}}">
                            </div>

         
                            <div class="form-group wsus__input">
                                <label >Status</label>
                                <select class="form-control wsus__input"  placeholder="Status" name="status">
                                    <option selected disabled>-- Select --</option>
                                    <option value="1">active</option>
                                    <option value="0">inactive</option>
                                </select>
                            </div>
                            

                            <input type="submit" class="btn btn-primary" name="submit" value="Create">

                        </form>
                        
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection