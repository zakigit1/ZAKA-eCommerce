@extends('Admin.Dashboard.layouts.master')
@section('title')
    {{ @$settings->site_name ." || Edit Footer Grid Three " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.footer-grid-three.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Edit Footer Grid Three</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.footer-grid-three.index') }}">Footer Grid Three</a>
                </div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">
                    {{-- <a href="{{ route('admin.footer-grid-three.index') }}" class="btn btn-primary "> <i
                            class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Footer Grid Three</h4>

                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.footer-grid-three.update', $footerGridThree->id) }}"
                                method="post">
                                @csrf
                                @method('PUT')


                                <div class="form-group">
                                    <label for="type">Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        placeholder="Name" value="{{ $footerGridThree->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="type">URL</label>
                                    <input type="text" name="url" class="form-control" placeholder="URL"
                                        value="{{ $footerGridThree->url }}">
                                </div>

                                <div class="form-group ">
                                    <label for="inputStatus">Status</label>
                                    <select class="form-control" id="inputStatus" placeholder="Status" name="status">

                                        <option @if ($footerGridThree->status) selected @endif value="1">active
                                        </option>
                                        <option {{ $footerGridThree->status == 0 ? 'selected' : '' }} value="0">
                                            inactive</option>

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
