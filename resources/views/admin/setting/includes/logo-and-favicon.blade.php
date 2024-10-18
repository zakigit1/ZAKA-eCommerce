{{-- <div class="card border">
    <div class="card-header">
        <h5 style="color:rgb(219, 80, 80)">!! NOTE : To See The Logo's in big format go to the bottum !!</h5>
    </div>
</div> --}}

<div class="card border">

    <div class="card-header">
        <h4>Logo and Favicon</h4>
    </div>
    


    <div class="card-body">

        <form action="{{route('admin.settings.logo-settings.update')}}" method="post" enctype="multipart/form-data">

            @csrf
            @method('PUT')

                <label><b>Logo</b></label> <br>
            @if (!is_null(@$logoSettings->logo))
                <i><b>View logo</b></i> <br>
                <img src="{{@$logoSettings->logo}}"  alt="logo-img" width="150px">
                <br><br>
            @endif
            
            <div class="form-group">
                <input class="form-control" type="file" name="logo" >
            </div>



        


            <label><b>Favicon</b></label> <br>
            @if (!is_null(@$logoSettings->favicon))
                <i><b>View favicon</b></i> <br>
                <img src="{{@$logoSettings->favicon}}"  alt="favicon-img" width="150px">
                <br><br>
            @endif
            

            <div class="form-group">
                <input class="form-control" type="file" name="favicon">
            </div>




            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>


{{-- <div class="card border">
    
        <div class="card-header">
            <h4>Logo </h4>
        </div>
        <div class="card-body text-center">
            @if (is_null($logoSettings->logo))
                <h3>No Logo found</h3>
            @else
                
                <img src="{{$logoSettings->logo}}" 
                width="720px"height ="300px" alt="Banner_img"> 
            @endif

        </div>



        <div class="card-header">
            <h4>Favicon </h4>
        </div>
        <div class="card-body text-center">
            @if (is_null($logoSettings->favicon))
                <h3>No Favicon found</h3>
            @else
                
                <img src="{{$logoSettings->favicon}}" 
                width="720px"height ="300px" alt="Banner_img"> 
            @endif

        </div>
   
</div> --}}