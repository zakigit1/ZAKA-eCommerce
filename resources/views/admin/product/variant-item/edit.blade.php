@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{"$settings->site_name ||Edit Admin Product Variant Item "}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Edit Variant Item</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            {{-- <div class="breadcrumb-item"><a href="{{route('admin.slider.index')}}">Brands</a></div> --}}
            <div class="breadcrumb-item">Edit</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <a href="{{route('admin.product-variant-item.index',[$product_id,$variant_id])}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                <div class="card">
                    <div class="card-header">
                        <h4> Update Variant Item</h4>
                    
                    </div>
                    <div class="card-body">
                        
                        <form action="{{route('admin.product-variant-item.update',$item->id)}}" method="post">

                            @csrf


                            <div class="form-group">
                                <label for="type">Variant Name</label>
                                <input type="text"  class="form-control"  placeholder="Variant Name" value="{{$item->variant->name}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="type">Item Name</label>
                                <input type="text" name="name" class="form-control"  placeholder="Item Name" value="{{$item->name}}" >
                            </div>
                            <div class="form-group">
                                <label for="type">Price <code>(Set 0 for make it free)</code></label>
                                <input type="text" name="price" class="form-control"  placeholder="Price (Set 0 for make it free)" value="{{$item->price}}" >
                            </div>

         
                            <div class="form-group ">
                                <label>Is Default</label>
                                <select class="form-control"  name="is_default">
                                    <option  selected disabled>-- Select --</option>
                                    <option @if($item->is_default == 1) selected @endif value="1">Yes</option>
                                    <option @if($item->is_default == 0) selected @endif value="0">No</option>
                                </select>
                            </div>

                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                    
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
    </section>
@endsection