@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ "$settings->site_name || Create New User/Vendor/Admin " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add New User/Vendor/Admin</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create New User/Vendor/Admin</h4>

                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.manage-user.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="type">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Name"
                                            value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="type">Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="Email"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="type">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password"
                                            >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="type">Password Confirmation</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Password Confirmation" >
                                    </div>
                                </div>



                                {{-- do the role in the config file for better --}}
                                <div class="form-group ">
                                    <label>Role</label>
                                    <select class="form-control" name="role">
                                            <option selected disabled>-- Select --</option>
                                        @foreach (config('user-role.roles') as $key =>$role)
                                            <option value="{{$key}}" >{{$role}}</option>
                                        @endforeach


                                        {{-- <option value="user">User</option>
                                        <option value="vendor">Vendor</option>
                                        <option value="admin">Admin</option> --}}
                                    </select>
                                </div>

                                <input type="submit" class="btn btn-primary" value="Create">

                            </form>

                        </div>
                    </div>

                </div>

            </div>
    </section>
@endsection
