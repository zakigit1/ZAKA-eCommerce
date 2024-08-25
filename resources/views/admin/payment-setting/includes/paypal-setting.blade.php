<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.payment.paypal-setting')}}" method="POST">

            @csrf
            @method('PUT')


            <div class="form-group ">
                <label >Paypal Status</label>
                <select class="form-control"  name="status">
                    <option @if(@$paypalSetting->status == 0) selected @endif value="0">Disable</option>
                    <option {{(@$paypalSetting->status == 1) ? 'selected' : '' }} value="1">Enable</option>
                </select>
            </div>

            <div class="form-group ">
                <label >Paypal Account Mode</label>
                <select class="form-control"  name="mode">
                    <option selected disabled>-- Select --</option>
                    <option {{(@$paypalSetting->mode == 'sandbox') ? 'selected' : '' }}  value="sandbox">Sandbox</option>
                    <option {{(@$paypalSetting->mode == 'live') ? 'selected' : '' }}  value="live">Live</option>
                </select>
            </div>


            <div class="form-group">
                <label >Country List</label>
                <select name="country_name"  class="form-control select2">
                        <option {{!isset($paypalSetting) ? 'selected' : ''}} value="" disabled >--Select--</option>
                    @foreach (config('settings.country_list') as $country)
                        <option {{@$paypalSetting->country_name == $country ? 'selected' : ''}} value="{{$country}}"> {{$country}} </option>
                    @endforeach
                </select>

            </div>



            <div class="form-group">
                <label>Currency Name</label>
                <select name="currency_name"  class="form-control select2">
                    <option {{!isset($paypalSetting) ? 'selected' : ''}} value="" disabled>--Select--</option>
                    @foreach (config('settings.currency_list') as $key => $currency)
                        <option {{@$paypalSetting->currency_name == $key  ? 'selected' : ''}} value="{{$key}}" >{{$currency}}</option>
                    @endforeach

                </select>
            </div>



            <div class="form-group">
                {{-- convert from you currency of site to USD  --}}
                <label >Currency Rate (Per {{$settings->currency_name}})</label>
                <input type="text" name="currency_rate" class="form-control" value="{{@$paypalSetting->currency_rate}}">
            </div>

            <div class="form-group">
                <label >Paypal Client Id</label>
                <input type="text" name="client_id" class="form-control" value="{{@$paypalSetting->client_id}}">
            </div>

            <div class="form-group">
                <label >Paypal Securet Key </label>
                <input type="text" name="secret_key" class="form-control" value="{{@$paypalSetting->secret_key}}">
            </div>



            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>