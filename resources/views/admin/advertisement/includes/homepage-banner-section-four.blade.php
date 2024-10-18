<div class="card border">
    <div class="card-header">
        <h5 style="color:rgb(219, 80, 80)">!! NOTE : To See The Banner's Go To The Bottum !!</h5>
    </div>
</div>

<div class="card border">
    <div class="card-header">
        <h4>Banner Section 4</h4>
    </div>

    <div class="card-body">

        <form action="{{route('admin.advertisement.homepage-banner-section-four')}}" method="post" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="form-group">
                <label>Show the banner section 4 on the home page</label>
                <br>
                <div class="row">
                    <p class="mt-3 ml-3"><b>Disbale</b></p>
                    <label  class="custom-switch ml-2" >
                        <input  type="checkbox"  class="custom-switch-input" name="status"
                            @if(@$homepageBannerSectionFour->status == 1) checked @endif>
                        <span class="custom-switch-indicator" ></span>
                    </label>

                    <p class="mt-3" style="margin-left: 10px"><b>Enable</b></p>
                </div>
            </div>



            <div class="form-group">
                <label >Banner Image</label>
                <input type="file" name="banner_image" class="form-control">
            </div>
            <div class="form-group">
                <label >Banner URL</label>
                <input type="text" name="banner_url" class="form-control"  placeholder="Banner URL" value="{{@$homepageBannerSectionFour->banner_url}}">
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>

<div class="card border">
    <div class="card-header">
        <h4>Banner Image</h4>
    </div>
    <div class="card-body text-center">
        @if (!isset($homepageBannerSectionFour->banner_image))
            <h3>No banners found</h3>
        @else
            <img src="{{asset($homepageBannerSectionFour->banner_image)}}" 
            width="720px"height ="300px" alt="Banner_img">
            
        @endif

    </div>
</div>