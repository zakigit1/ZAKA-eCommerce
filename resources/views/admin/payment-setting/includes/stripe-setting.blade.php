<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.payment.stripe-setting')}}" method="POST">

            @csrf
            @method('PUT')


            <div class="form-group ">
                <label >Stripe Status</label>
                <select class="form-control"  name="status">
                    <option @if(@$stripeSetting->status == 0) selected @endif value="0">Disable</option>
                    <option {{(@$stripeSetting->status == 1) ? 'selected' : '' }} value="1">Enable</option>
                </select>
            </div>

            <div class="form-group ">
                <label >Stripe Account Mode</label>
                <select class="form-control"  name="mode">
                    <option selected disabled>-- Select --</option>
                    <option {{(@$stripeSetting->mode == 'sandbox') ? 'selected' : '' }}  value="sandbox">Sandbox</option>
                    <option {{(@$stripeSetting->mode == 'live') ? 'selected' : '' }}  value="live">Live</option>
                </select>
            </div>


            <div class="form-group">
                <label >Country List</label>
                <select name="country_name"  class="form-control select2">
                        <option {{!isset($stripeSetting) ? 'selected' : ''}} value="" disabled >--Select--</option>
                    @foreach (config('settings.country_list') as $country)
                        <option {{@$stripeSetting->country_name == $country ? 'selected' : ''}} value="{{$country}}"> {{$country}} </option>
                    @endforeach
                </select>

            </div>



            <div class="form-group">
                <label>Currency Name</label>
                <select name="currency_name"  class="form-control select2">
                    <option {{!isset($stripeSetting) ? 'selected' : ''}} value="" disabled>--Select--</option>
                    @foreach (config('settings.currency_list') as $key => $currency)
                        <option {{@$stripeSetting->currency_name == $key  ? 'selected' : ''}} value="{{$key}}" >{{$currency}}</option>
                    @endforeach

                </select>
            </div>



            <div class="form-group">
                {{-- convert from you currency to USD  --}}
                <label >Currency Rate (Per {{@$settings->currency_name}})</label>
                <input type="text" name="currency_rate" class="form-control" placeholder="Enter Convert currency" value="{{@$stripeSetting->currency_rate}}">
            </div>

            <div class="form-group">
                <label >Stripe Client Id</label>
                <input type="text" name="client_id" class="form-control" placeholder="Enter Stripe Client Id" value="{{@$stripeSetting->client_id}}">
            </div>

            <div class="form-group">
                <label >Stripe Securet Key </label>
                <input type="text" name="secret_key" class="form-control" placeholder="Enter Stripe Secret Key" value="{{@$stripeSetting->secret_key}}">
            </div>



            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>