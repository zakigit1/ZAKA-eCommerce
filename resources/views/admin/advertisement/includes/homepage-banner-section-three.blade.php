
<div class="card border">
    <div class="card-header">
        <h5 style="color:rgb(219, 80, 80)">!! NOTE : To See The Banner's Go To The Bottum !!</h5>
    </div>
</div>




<div class="card border">
    <div class="card-header">
        <h4>Banner Section 3</h4>
    </div>

    <div class="card-body">

        <form action="{{route('admin.advertisement.homepage-banner-section-three')}}" method="post" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Show the banners section 3 on the home page</label>
                <br>
                <div class="row">
                    <p class="mt-3 ml-3"><b>Disbale</b></p>
                    <label  class="custom-switch ml-2" >
                        <input  type="checkbox"  class="custom-switch-input" name="status"
                            @if(@$homepageBannerSectionThree[3]->status == 1) checked @endif>
                        <span class="custom-switch-indicator" ></span>
                    </label>

                    <p class="mt-3" style="margin-left: 10px"><b>Enable</b></p>
                </div>
            </div>

            <hr>
            @for($i=1 ;$i<=3 ;$i++)
                <h5>Banner {{$i}}</h5><br>

                <div class="form-group">
                    <label >Banner Image {{$i}}</label>
                    <input type="file" name="banner_image_{{$i}}" class="form-control">
                </div>
                <div class="form-group">
                    <label >Banner URL {{$i}}</label>
                    <input type="text" name="banner_url_{{$i}}" class="form-control"  placeholder="Banner URL" value="{{ @$homepageBannerSectionThree[$i-1]->{'banner_'.$i}->{'banner_url_'.$i} }}">
                </div>

                <hr>
            @endfor

            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>



</div>




<div class="card border">
    @for($i=0 ;$i<=2 ;$i++)
        <div class="card-header">
            <h4>Banner Image {{$i+1}}</h4>
        </div>
        <div class="card-body text-center">
            @if (!isset($homepageBannerSectionThree[$i]->{'banner_'.$i+1}->{'banner_image_'.$i+1}))
                <h3>No banners found</h3>
            @else
                
                <img src="{{asset($homepageBannerSectionThree[$i]->{'banner_'.$i+1}->{'banner_image_'.$i+1})}}" 
                width="720px"height ="300px" alt="Banner_img">
                
            @endif

        </div>
    @endfor
</div>