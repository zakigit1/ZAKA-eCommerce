<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.payment.razorpay-setting')}}" method="POST">

            @csrf
            @method('PUT')


            <div class="form-group ">
                <label >Razorpay Status</label>
                <select class="form-control"  name="status">
                    <option @if(@$razorpaySetting->status == 0) selected @endif value="0">Disable</option>
                    <option {{(@$razorpaySetting->status == 1) ? 'selected' : '' }} value="1">Enable</option>
                </select>
            </div>


            <div class="form-group">
                <label >Country List</label>
                <select name="country_name"  class="form-control select2">
                        <option {{!isset($razorpaySetting) ? 'selected' : ''}} value="" disabled >--Select--</option>
                    @foreach (config('settings.country_list') as $country)
                        <option {{@$razorpaySetting->country_name == $country ? 'selected' : ''}} value="{{$country}}"> {{$country}} </option>
                    @endforeach
                </select>

            </div>



            <div class="form-group">
                <label>Currency Name</label>
                <select name="currency_name"  class="form-control select2">
                    <option {{!isset($razorpaySetting) ? 'selected' : ''}} value="" disabled>--Select--</option>
                    @foreach (config('settings.currency_list') as $key => $currency)
                        <option {{@$razorpaySetting->currency_name == $key  ? 'selected' : ''}} value="{{$key}}" >{{$currency}}</option>
                    @endforeach

                </select>
            </div>



            <div class="form-group">
                {{-- convert from you currency to USD  --}}
                <label >Currency Rate (Per {{$settings->currency_name}})</label>
                <input type="text" name="currency_rate" class="form-control" placeholder="Enter Convert currency" value="{{@$razorpaySetting->currency_rate}}">
            </div>

            <div class="form-group">
                <label >Razorpay Key</label>
                <input type="text" name="razorpay_key" class="form-control" placeholder="Enter Razorpay Key" value="{{@$razorpaySetting->razorpay_key}}">
            </div>

            <div class="form-group">
                <label >Razorpay Securet Key </label>
                <input type="text" name="razorpay_secret_key" class="form-control" placeholder="Enter Razorpay Secret Key" value="{{@$razorpaySetting->razorpay_secret_key}}">
            </div>



            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>