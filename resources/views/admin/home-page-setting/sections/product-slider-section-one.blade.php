<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.home-page-setting.product-slider-section-one.update')}}" method="post">

            @csrf
            @method('PUT')

            <div class="row">
                <!-- Category -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label >Category</label>
                        <select  name="category" class="form-control  main-category">
                            @if (is_null($productSliderSectionOne->category))
                                    <option  selected  value="">-- Select --</option>
                                @if (isset($categories) && count($categories)>0)
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            @else  
                                @if (isset($categories) && count($categories)>0)
                                    @foreach ($categories as $category)
                                        <option {{$category->id == $productSliderSectionOne->category ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            @endif
                            
                        </select>
                    </div>
                </div>

                <!-- Sub-Category -->
                <div class="col-md-4">
                    <div class="form-group">
                        @php 
                            $subCategories = \App\Models\Subcategory::where('category_id',@$productSliderSectionOne->category)->active()->get(['id','name']);
                        @endphp


                        <label >Sub Categories</label>
                        <select class="form-control sub-category"  name="sub_category">
                            

                            @if (is_null($productSliderSectionOne->sub_category))
                                    <option  selected  value="">-- Select --</option>
                                    @if(isset($subCategories) && count($subCategories)>0)
                                        @foreach ($subCategories as $subCategory)
                                            <option value="{{$subCategory->id}}">
                                                {{$subCategory->name}} 
                                            </option>
                                        @endforeach
                                    @endif
                            @else  
                                    @if(isset($subCategories) && count($subCategories)>0)    
                                        @foreach ($subCategories as $subCategory)
                                            <option {{$subCategory->id == $productSliderSectionOne->sub_category ? 'selected' : ''}} value="{{$subCategory->id}}">
                                                {{$subCategory->name}} 
                                            </option>
                                        @endforeach
                                    @endif
                                    <option value="">none</option>
                            @endif

                        </select>
                    </div>
                </div>

                <!-- Child-Category -->
                <div class="col-md-4">
                    <div class="form-group">
                        @php 
                            $childCategories = \App\Models\Childcategory::where('sub_category_id',@$productSliderSectionOne->sub_category)->active()->get(['id','name']);
                        @endphp

                        <label >Child Categories</label>
                        <select class="form-control child-category"  name="child_category">
                        

                            @if (is_null($productSliderSectionOne->child_category))
                                    <option  selected  value="">-- Select --</option>
                                @if (isset($childCategories) && count($childCategories)>0)
                                    @foreach ($childCategories as $childCategory)
                                        <option value="{{$childCategory->id}}">
                                            {{$childCategory->name}} 
                                        </option>
                                    @endforeach
                                @endif
                            @else  
                                @if (isset($childCategories) && count($childCategories)>0)    
                                    @foreach ($childCategories as $childCategory)
                                        <option {{$childCategory->id == $productSliderSectionOne->child_category ? 'selected' : ''}} value="{{$childCategory->id}}">
                                            {{$childCategory->name}} 
                                        </option>
                                    @endforeach
                                @endif
                                <option value="">none</option>
                            @endif


                        </select>
                    </div> 
                </div> 
                
            </div>    
            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>


@push('scripts')
   <script>
        $(document).ready(function(){

            //              get sub categories : 

            $('body').on('change', '.main-category', function(e){

                let id = $(this).val();
                let row = $(this).closest('.row');

                $.ajax({
                    method: 'GET',
                    url: '{{route("admin.home-page-setting.get-sub-categories")}}',
                    data: {
                        category_id: id,
                    },
                    success: function(data){
                        let selectorSubcategory = row.find('.sub-category');
                        let selectorChildcategory = row.find('.child-category');
                        //this line to reset the sub-categories when you change the category  
                        selectorSubcategory.html('<option selected value="">Select</option>');
                        //this line to reset the child-categories when you change the category  
                        selectorChildcategory.html('<option selected value="">Select</option>');

                        $.each(data, function(i, item) {
                            // $('.sub-category').append('<option value="'+item.id+'">'+item.name+'</option>');
                        
                            selectorSubcategory.append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error){
                        console.log('error');
                    }
                });
            });

            //              get child categories : 

            $('body').on('change', '.sub-category', function(e){
                
                let id = $(this).val();
                let row = $(this).closest('.row');

                $.ajax({
                    method: 'GET',
                    url: '{{route("admin.home-page-setting.get-child-categories")}}',
                    data: {
                        sub_category_id: id,
                    },
                    success: function(data){
                        let selector = row.find('.child-category');
                        selector.html('<option selected value="">Select</option>');

                        $.each(data, function(i, item) {
                        
                            selector.append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error){
                        console.log('error');
                    }
                });
            });
        });
    </script> 
@endpush