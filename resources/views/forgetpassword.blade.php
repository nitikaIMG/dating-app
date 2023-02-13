<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$data['title']}}</title>
</head>
<body>
    <h6>{{$data['body']}}</h6>
    {{-- <a style="text-color:black;" href="{{$data['url']}}">Reset Password</a> --}}
    <h2>Your Otp For Reset Password <br> {{$data['otp']}}</h2>
    <p>Thank You</p>
</body>
</html>