@extends('Admin.Dashboard.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Add New Brand</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            {{-- <div class="breadcrumb-item"><a href="{{route('admin.slider.index')}}">Brands</a></div> --}}
            <div class="breadcrumb-item">Edit</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <!-- request()->id (it is the id of we pass it in the route {id}) -->
                {{-- <a href="{{route('admin.product-variant.index',['id'=>request()->id])}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a> --}}
                <a href="{{route('admin.product-variant.index',['id'=>$variant->product_id])}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
               
                <br>
                <div class="card">
                    <div class="card-header">
                        <h4> Edit Variant</h4>
                    
                    </div>
                    <div class="card-body">
                        
                        <form action="{{route('admin.product-variant.update',$variant->id)}}" method="post">

                            @csrf

                            
                            <div class="form-group">
                                <label for="type">Variant Name</label>
                                <input type="text" name="name" class="form-control" id="" placeholder="Variant Name" value="{{$variant->name}}">
                            </div>

         
                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
                                    
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
    </section>
@endsection