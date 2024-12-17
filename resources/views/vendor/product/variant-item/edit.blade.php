@extends('vendor.Dashboard.layouts.master')

@section('title')
    {{"$settings->site_name || Edit Vendor Product Variant Item  "}}
@endsection


@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <div class="back_button">
                    <a href="{{route('vendor.product-variant-item.index',[$product_id,$variant_id])}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                </div>
                <br>
                <h3><i class="far fa-user"></i> Edit Variant Product Item</h3>

                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">

                        <h4> Update Variant Item</h4>
                        <form action="{{route('vendor.product-variant-item.update',$item->id)}}" method="post">

                            @csrf


                            <div class="form-group wsus__input">
                                <label for="type">Variant Name</label>
                                <input type="text"  class="form-control"  placeholder="Variant Name" value="{{$item->variant->name}}" readonly>
                            </div>
                            <div class="form-group wsus__input">
                                <label for="type">Item Name</label>
                                <input type="text" name="name" class="form-control"  placeholder="Item Name" value="{{$item->name}}" >
                            </div>
                            <div class="form-group wsus__input">
                                <label for="type">Price <code>(Set 0 for make it free)</code></label>
                                <input type="text" name="price" class="form-control"  placeholder="Price (Set 0 for make it free)" value="{{$item->price}}" >
                            </div>

         
                            <div class="form-group wsus__input">
                                <label>Is Default</label>
                                <select class="form-control wsus__input"  name="is_default">
                                    <option  selected disabled>-- Select --</option>
                                    <option @if($item->is_default == 1) selected @endif value="1">Yes</option>
                                    <option @if($item->is_default == 0) selected @endif value="0">No</option>
                                </select>
                            </div>

                            <div class="form-group wsus__input">
                                <label for="inputStatus">Status</label>
                                <select class="form-control wsus__input" id="inputStatus" placeholder="Status" name="status">
                                    
                                    <option @if($item->status == 1) selected @endif value="1">active</option>
                                    <option {{($item->status == 0) ? 'selected' : '' }} value="0">inactive</option>
                                    
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