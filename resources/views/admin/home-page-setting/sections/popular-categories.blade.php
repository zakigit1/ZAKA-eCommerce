<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.home-page-setting.popular-category.update')}}" method="post">

            @csrf
            @method('PUT')

  
            <h5>Category 1 </h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label >Category</label>
                        <select  name="cat_one" class="form-control  main-category">
                            
        
                                <option selected disabled>-- Select --</option>
                            @foreach ($categories as $category)
                                <option  value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label >Sub Categories</label>
                        <select class="form-control sub-category"  name="sub_cat_one">
                        
                            <option selected disabled>-- Select --</option>

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label >Child Categories</label>
                        <select class="form-control child-category"  name="child_cat_one">
                        
                            <option selected disabled>-- Select --</option>

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
                                <option  value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label >Sub Categories</label>
                        <select class="form-control sub-category"  name="sub_cat_two">
                        
                            <option selected disabled>-- Select --</option>

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label >Child Categories</label>
                        <select class="form-control child-category"  name="child_cat_two">
                        
                            <option selected disabled>-- Select --</option>

                        </select>
                    </div> 
                </div> 
                
            </div>

            <h5>Category 3 </h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label >Category</label>
                        <select  name="cat_three" class="form-control  main-category">
                            
        
                                <option selected disabled>-- Select --</option>
                            @foreach ($categories as $category)
                                <option  value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label >Sub Categories</label>
                        <select class="form-control sub-category"  name="sub_cat_three">
                        
                            <option selected disabled>-- Select --</option>

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label >Child Categories</label>
                        <select class="form-control child-category"  name="child_cat_three">
                        
                            <option selected disabled>-- Select --</option>

                        </select>
                    </div> 
                </div> 
                
            </div>

            <h5>Category 4 </h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label >Category</label>
                        <select  name="cat_four" class="form-control  main-category">
                            
        
                                <option selected disabled>-- Select --</option>
                            @foreach ($categories as $category)
                                <option  value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label >Sub Categories</label>
                        <select class="form-control sub-category"  name="sub_cat_four">
                        
                            <option selected disabled>-- Select --</option>

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label >Child Categories</label>
                        <select class="form-control child-category"  name="child_cat_four">
                        
                            <option selected disabled>-- Select --</option>

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