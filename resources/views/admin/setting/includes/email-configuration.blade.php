<div class="card border">
    <div class="card-body">

        <form action="{{route('admin.settings.email-settings.update')}}" method="post">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label >Email</label>
                <input type="text" name="email" class="form-control"  placeholder="Email" value="{{@$emailConfig->email}}">
            </div>

            <div class="form-group">
                <label >Mail Host</label>
                <input type="text" name="host" class="form-control"  placeholder="Mail Host" value="{{@$emailConfig->host}}">
            </div>


            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label >SMTP Username</label>
                        <input type="text" name="username" class="form-control"  placeholder="SMTP Username" value="{{@$emailConfig->username}}">
                    </div>
                </div>
                    
                    
                <div class="col-6">
                    <div class="form-group">
                        <label>SMTP Password</label>
                        <input type="text" name="password" class="form-control"  placeholder="SMTP Password" value="{{@$emailConfig->password}}">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-6">
                    
                    <div class="form-group">
                        <label >Mail Port</label>
                        <input type="text" name="port" class="form-control"  placeholder="Mail Port" value="{{@$emailConfig->port}}">
                    </div>
                </div>
                    
                <div class="col-6">
                    <div class="form-group">
                        <label>Mail Encryption</label>
        
                        <select name="encryption" class="form-control">
                            <option  value="" disabled>--Select--</option>
                            
                            <option {{ @$emailConfig->encryption =='tls' ? 'selected' : ''}} value="tls">TLS</option>
                            <option {{ @$emailConfig->encryption =='ssl' ? 'selected' : ''}} value="ssl">SSL</option>
        
                        </select>
                    </div>

                </div>
            </div>



            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>