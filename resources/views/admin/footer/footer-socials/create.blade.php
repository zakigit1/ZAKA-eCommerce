@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{"$settings->site_name || Create Admin Footer Social "}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Add New Footer Social</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('admin.footer-socials.index')}}">Footer Socials</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
        </div>

        <div class="section-body">


        <div class="row">
            <div class="col-12 ">
                <a href="{{route('admin.footer-socials.index')}}" class="btn btn-primary" > <i class="fas fa-chevron-circle-left"></i> Back</a>
                <br><br>
                <div class="card">
                    <div class="card-header">
                     <h4>Create New Footer Social</h4>
    
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.footer-socials.store')}}" method="post" >
                            @csrf

                            <label for="icon">Social Icon</label>

                            <div class="form-group">
                                <button id='icon'  name="icon" 
                                {{-- style="font-size: 2rem" --}}
                                
                                    class="btn btn-warning" role="iconpicker"
                                    data-align="right"
                                    data-rows="8"
                                    data-cols="10" 
                                    data-arrow-class="btn-info"
                                    data-arrow-prev-icon-class="fas fa-angle-left"
                                    data-arrow-next-icon-class="fas fa-angle-right"
                                    data-selected-class="btn-danger"
                                    data-unselected-class="btn-success">
                                </button>
                                
                            </div>


                            <div class="form-group">
                                <label for="type">Social Name</label>
                                <input type="text" name="name" class="form-control"  placeholder="Social Name" value="{{old('name')}}">
                            </div>

                            <div class="form-group">
                                <label for="type">Social URL</label>
                                <input type="text" name="url" class="form-control"  placeholder="Social URL" value="{{old('url')}}">
                            </div>



                            <div class="form-group ">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" placeholder="Status" name="status">
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
    </section>
@endsection