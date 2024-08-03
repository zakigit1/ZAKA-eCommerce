@extends('vendor.Dashboard.layouts.master')



@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-user"></i> Edit Variant Product</h3>

                <div class="back_button">
                    <a href="{{route('vendor.product-variant.index',['id'=>$variant->product_id])}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                </div>
                
                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        
                        <form action="{{route('vendor.product-variant.update',$variant->id)}}" method="post">

                            @csrf

                            
                            <div class="form-group wsus__input">
                                <label for="type">Variant Name</label>
                                <input type="text" name="name" class="form-control" id="" placeholder="Variant Name" value="{{$variant->name}}">
                            </div>

         
                            <div class="form-group wsus__input">
                                <label for="inputStatus">Status</label>
                                <select class="form-control wsus__input" id="inputStatus" placeholder="Status" name="status">
                                    
                                    <option @if($variant->status == 1) selected @endif value="1">active</option>
                                    <option {{($variant->status == 0) ? 'selected' : '' }} value="0">inactive</option>
                                    
                                </select>
                            </div>
                            

                            <input type="submit" class="btn btn-primary" name="submit" value="Update">

                        </form>
        
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection