@extends('Admin.Dashboard.layouts.master')

@section('title')
    {{ "$settings->site_name || Edit Child Category " }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.child-category.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"
                        style="font-size:25px"></i></a>
            </div>
            <h1>Edit Child-Category</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.child-category.index') }}">Child-Categories</a></div>
                <div class="breadcrumb-item">Edit</div>
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
                            <h4>Edit Child Category</h4>

                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.child-category.update', $childcategory->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                {{-- <input type="hidden" name="id" > --}}


                                <div class="form-group ">
                                    <label>Categories</label>
                                    <select class="form-control main-category" id="inputStatus" name="category">

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $childcategory->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Subategories</label>
                                    <select class="form-control sub-category" name="subcategory">
                                        <option selected disabled>--select--</option>

                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ $subcategory->id == $childcategory->sub_category_id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type">Childcategory Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        placeholder="Childcategory Name" value="{{ $childcategory->name }}">
                                </div>

                                <div class="form-group ">
                                    <label for="inputStatus">Status</label>
                                    <select class="form-control" id="inputStatus" placeholder="Status" name="status">

                                        <option @if ($childcategory->status) selected @endif value="1">active
                                        </option>
                                        <option {{ $childcategory->status == 0 ? 'selected' : '' }} value="0">
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
