@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Create Child Category " }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.child-category.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>

            <h1>Add New Child-Category</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.child-category.index') }}">Child-Categories</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 ">
                    {{-- <a href="{{ route('admin.child-category.index') }}" class="btn btn-primary"> <i
                            class="fas fa-chevron-circle-left"></i> Back</a>
                    <br><br> --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Create New Child Category</h4>

                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.child-category.store') }}" method="post">
                                @csrf



                                <div class="form-group ">
                                    <label>Categories</label>
                                    <select class="form-control  main-category" name="category">

                                        <option selected disabled>-- Select --</option>

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Sub Categories</label>
                                    <select class="form-control sub-category" name="subcategory">

                                        <option selected disabled>-- Select --</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="type">ChildCategory Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        placeholder="Childcategory Name" value="{{ old('name') }}">
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


<!-- get Subcategories ajax : -->

@push('scripts')
    <script>
        $(document).ready(function() {
            $('body').on('change', '.main-category', function(e) {

                let id = $(this).val();

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.child-category.get-sub-categories') }}',
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        $('.sub-category').html('<option selected disabled>Select</option>');

                        $.each(data, function(i, item) {
                            // $('.sub-category').append('<option value="'+item.id+'">'+item.name+'</option>');

                            $('.sub-category').append(
                                `<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('error');
                    }
                });
            });
        });
    </script>
@endpush
