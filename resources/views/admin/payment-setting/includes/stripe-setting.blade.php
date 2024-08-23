<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.settings.general-settings.update')}}" method="post">

            @csrf
            @method('PUT')


            <div class="form-group ">
                <label >Status</label>
                <select class="form-control"  name="status">
                    <option selected disabled>-- Select --</option>
                    <option value="0">Disable</option>
                    <option value="1">Enable</option>
                </select>
            </div>

            <div class="form-group ">
                <label >Account Mode</label>
                <select class="form-control"  name="mode">
                    <option selected disabled>-- Select --</option>
                    <option value="0">Sandbox</option>
                    <option value="1">Live</option>
                </select>
            </div>


            <div class="form-group">
                <label >Country List</label>
                <select   name="country_list"  class="form-control select2">
                    <option value="" disabled >Select</option>
                    @foreach (config('settings.country_list') as $key => $country)
                        <option  value="{{$key}}"> {{$country}} </option>
                    @endforeach
                </select>

            </div>



            <div class="form-group">
                <label>Currency Name</label>
                <select name="currency_name"  class="form-control select2">
                    <option value="" disabled >Select</option>
                    @foreach (config('settings.currency_list') as $currency)
                        <option value="{{$currency}}" >{{$currency}}</option>
                    @endforeach

                </select>
            </div>



            <div class="form-group">
                <label >Currency Rate (Per USD)</label>
                <input type="text" name="currency_rate" class="form-control" value="{{old('currency_rate')}}">
            </div>

            <div class="form-group">
                <label >Paypal Client Id</label>
                <input type="text" name="client_id" class="form-control" value="{{old('client_id')}}">
            </div>

            <div class="form-group">
                <label >Paypal Securet Key </label>
                <input type="text" name="securet_key" class="form-control" value="{{old('securet_key')}}">
            </div>



            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>
</div>