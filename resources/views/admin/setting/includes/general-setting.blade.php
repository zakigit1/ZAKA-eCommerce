<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.settings.general-settings.update')}}" method="post">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label >Site Name</label>
                <input type="text" name="site_name" class="form-control"  placeholder="Site Name" value="{{@$generalSetting->site_name}}">
            </div>
            <div class="form-group">
                <label >Layouts</label>
                <select  name="layout" class="form-control">
                    <option {{@$generalSetting->layout == 'ltr' ? 'selected' : ''}} value="ltr">LTR</option>
                    <option {{@$generalSetting->layout == 'rtl' ? 'selected' : ''}} value="rtl">RTL</option>
                </select>
            </div>
            <div class="form-group">
                <label >Contact Email</label>
                <input type="text" name="contact_email" class="form-control"  placeholder="Contact Email" value="{{@$generalSetting->contact_email}}">
            </div>
            <div class="form-group">
                <label >Default Currency Name</label>
                <select name="currency_name"  class="form-control select2">
                    <option value="" disabled >Select</option>
                    @foreach (config('settings.currency_list') as $currency)
                        <option {{@$generalSetting->currency_name == $currency ? 'selected' : ''}} value="{{$currency}}" >{{$currency}}</option>
                    @endforeach

                </select>
                
            </div>
            <div class="form-group">
                <label >Currency Icon</label>
                {{-- <input type="text" name="currency_icon" class="form-control"  placeholder="Currency Icon" value="{{@$generalSetting->currency_icon}}"> --}}
                <select   name="currency_icon"  class="form-control select2">
                    <option value="" disabled >Select</option>
                    @foreach (config('settings.currency_symbol') as $key => $currency_symbol)
                        <option {{@$generalSetting->currency_icon == $currency_symbol ? 'selected' : ''}} value="{{$currency_symbol}}" >{{$currency_symbol}}</option>
                    @endforeach
                </select>

            </div>
            <div class="form-group">
                <label >Time Zone</label>

                <select   name="time_zone"  class="form-control select2">
                    <option value="" disabled >Select</option>
                    @foreach (config('settings.timezone_list') as $key => $timezone)
                        <option {{@$generalSetting->time_zone == $key ? 'selected' : ''}} value="{{$key}}" >{{$key}}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>