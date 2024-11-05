<div class="card border">
    <div class="card-header">
        <h4>Pusher Configuration</h4>
    </div>

    <div class="card-body">

        <form action="{{route('admin.settings.pusher-settings.update')}}" method="post">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Pusher App Id</label>
                <input type="text" name="pusher_app_id" class="form-control"  placeholder="Enter Pusher App Id" value="{{@$pusherConfig->pusher_app_id}}">
            </div>

            <div class="form-group">
                <label>Pusher Key</label>
                <input type="text" name="pusher_key" class="form-control"  placeholder="Enter Pusher Key" value="{{@$pusherConfig->pusher_key}}">
            </div>


            <div class="form-group">
                <label>Pusher Secret</label>
                <input type="text" name="pusher_secret" class="form-control"  placeholder="Enter Pusher Secret" value="{{@$pusherConfig->pusher_secret}}">
            </div>

            
            

            <div class="form-group">
                <label>Pusher Cluster</label>
                <input type="text" name="pusher_cluster" class="form-control"  placeholder="Enter Pusher Cluster" value="{{@$pusherConfig->pusher_cluster}}">
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>