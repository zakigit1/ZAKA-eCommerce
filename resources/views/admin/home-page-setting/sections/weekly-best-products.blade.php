<div class="card border">
    <div class="card-body">

        <form action="{{ route('admin.home-page-setting.weekly-best-products.update') }}" method="post">

            @csrf
            @method('PUT')


            {{-- <h5>Category 1 </h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label >Category</label>
                        <select  name="cat_one" class="form-control  main-category">
                            

                            @if (is_null(@@$weeklyBestProducts[0]->category))
                                <option selected disabled value="">-- Select --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @else
                                @foreach ($categories as $category)
                                    <option
                                        {{ $category->id == $weeklyBestProducts[0]->category ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                            
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        @php 
                            $subCategories = \App\Models\Subcategory::where('category_id',@$weeklyBestProducts[0]->category)->active()->get(['id','name']);
                        @endphp


                        <label >Sub Categories</label>
                        <select class="form-control sub-category"  name="sub_cat_one">
                            
                                <option disabled value="">-- Select --</option>
                            @foreach ($subCategories as $subCategory)
                                <option {{$subCategory->id == @$weeklyBestProducts[0]->sub_category ? 'selected' : ''}} value="{{$subCategory->id}}">
                                    {{$subCategory->name}} 
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        @php 
                            $childCategories = \App\Models\Childcategory::where('sub_category_id',@$weeklyBestProducts[0]->sub_category)->active()->get(['id','name']);
                        @endphp

                        <label >Child Categories</label>
                        <select class="form-control child-category"  name="child_cat_one">
                        
                                <option disabled value="">-- Select --</option>
                            @foreach ($childCategories as $childCategory)
                                <option {{$childCategory->id == @$weeklyBestProducts[0]->child_category ? 'selected' : ''}} value="{{$childCategory->id}}">
                                    {{$childCategory->name}} 
                                </option>
                            @endforeach

                        </select>
                    </div> 
                </div> 
                
            </div>

            <h5>Category 2 </h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label >Category</label>
                        <select  name="cat_two" class="form-control  main-category">
                            
        
                                <option selected disabled>-- Select --</option>
                            @foreach ($categories as $category)
                                <option {{$category->id == @$weeklyBestProducts[1]->category ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        @php 
                        $subCategories = \App\Models\Subcategory::where('category_id',@$weeklyBestProducts[1]->category)->active()->get(['id','name']);
                    @endphp
                        <label >Sub Categories</label>
                        <select class="form-control sub-category"  name="sub_cat_two">
                        
                                <option  disabled value="">-- Select --</option>
                            @foreach ($subCategories as $subCategory)
                                <option {{$subCategory->id == @$weeklyBestProducts[1]->sub_category ? 'selected' : ''}} value="{{$subCategory->id}}">
                                    {{$subCategory->name}} 
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        @php 
                            $childCategories = \App\Models\Childcategory::where('sub_category_id',@$weeklyBestProducts[1]->sub_category)->active()->get(['id','name']);
                        @endphp
                        <label >Child Categories</label>
                        <select class="form-control child-category"  name="child_cat_two">
                        
                                <option  disabled value="">-- Select --</option>
                            @foreach ($childCategories as $childCategory)
                                <option {{$childCategory->id == @$weeklyBestProducts[1]->child_category ? 'selected' : ''}} value="{{$childCategory->id}}">
                                    {{$childCategory->name}} 
                                </option>
                            @endforeach

                        </select>
                    </div> 
                </div> 
                
            </div> --}}

            {{-- ------------------------------------------------Method 2 (more professional)----------------------------------------- --}}

            @for ($i = 0; $i <= 1; $i++)

                <h5>Weekly Best {{ $i == 0 ? 'Rated ' : 'Sale ' }}Products</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="cat_{{$i + 1}}" class="form-control  main-category">


                                @if (is_null(@@$weeklyBestProducts[$i]->category))
                                    <option selected disabled value="">-- Select --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @else
                                    @foreach ($categories as $category)
                                        <option
                                            {{ $category->id == $weeklyBestProducts[$i]->category ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif


                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                $subCategories = \App\Models\Subcategory::where('category_id',@$weeklyBestProducts[$i]->category)
                                    ->active()
                                    ->get(['id', 'name']);

                                    // dd($subCategories);
                            @endphp

                                

                            <label>Sub Categories</label>
                            <select class="form-control sub-category" name="sub_cat_{{$i + 1}}">


                                <option {{ is_null(@$weeklyBestProducts[$i]->sub_category) ? 'selected' : '' }} value="">--Select--</option>
                                @foreach ($subCategories as $subCategory)
                                    <option
                                        {{ $subCategory->id == $weeklyBestProducts[$i]->sub_category ? 'selected' : ''}}                                        value="{{ $subCategory->id }}">
                                        {{ $subCategory->name }}
                                    </option>
                                @endforeach
                                

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            @php
                                $childCategories = \App\Models\Childcategory::where('sub_category_id', @$weeklyBestProducts[$i]->sub_category)
                                    ->active()
                                    ->get(['id', 'name']);
                            @endphp

                            <label>Child Categories</label>
                            <select class="form-control child-category" name="child_cat_{{$i + 1}}">

                                @if (is_null(@$weeklyBestProducts[$i]->child_category))
                                    <option selected value="">-- Select --</option>

                                    @foreach ($childCategories as $childCategory)
                                        <option value="{{ $childCategory->id }}">
                                            {{ $childCategory->name }}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach ($childCategories as $childCategory)
                                        <option
                                            {{ $childCategory->id == $weeklyBestProducts[$i]->child_category ? 'selected' : '' }}
                                            value="{{ $childCategory->id }}">
                                            {{ $childCategory->name }}
                                        </option>
                                    @endforeach
                                    <option value="">none</option>
                                @endif

                            </select>
                        </div>
                    </div>

                </div>
            @endfor



            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

            //              get sub categories : 

            $('body').on('change', '.main-category', function(e) {

                let id = $(this).val();
                let row = $(this).closest('.row');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.home-page-setting.get-sub-categories') }}',
                    data: {
                        category_id: id,
                    },
                    success: function(data) {
                        let selectorSubcategory = row.find('.sub-category');
                        let selectorChildcategory = row.find('.child-category');
                        //this line to reset the sub-categories when you change the category  
                        selectorSubcategory.html('<option selected value="">Select</option>');
                        //this line to reset the child-categories when you change the category  
                        selectorChildcategory.html('<option selected value="">Select</option>');

                        $.each(data, function(i, item) {
                            // $('.sub-category').append('<option value="'+item.id+'">'+item.name+'</option>');

                            selectorSubcategory.append(
                                `<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('error');
                    }
                });
            });

            //              get child categories : 

            $('body').on('change', '.sub-category', function(e) {

                let id = $(this).val();
                let row = $(this).closest('.row');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.home-page-setting.get-child-categories') }}',
                    data: {
                        sub_category_id: id,
                    },
                    success: function(data) {
                        let selector = row.find('.child-category');
                        selector.html('<option selected value="">Select</option>');

                        $.each(data, function(i, item) {

                            selector.append(
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
