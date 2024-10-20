<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.payment.cod-setting')}}" method="POST">

            @csrf
            @method('PUT')


            <div class="form-group ">
                <label >COD Status</label>
                <select class="form-control"  name="status">
                    <option @if(@$codSetting->status == 0) selected @endif value="0">Disable</option>
                    <option {{(@$codSetting->status == 1) ? 'selected' : '' }} value="1">Enable</option>
                </select>
            </div>



            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>