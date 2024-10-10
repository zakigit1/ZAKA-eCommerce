
@php 
    $website_name = \App\Models\GeneralSetting::first()->site_name ;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
</head>
<body>

    <h1>Hi ,{{$name}} </h1>
        <p>welcome to our <b style="color:red"> {{$website_name}} </b> e-commerce website </p>
    <hr>
    <p><b>Here Is Your Login Credentials :</b></p>
    <p>Email : {{$email}}</p>
    <p>Password : {{$email}}</p>
    
</body>
</html>