<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$users->id}}">
        <input type="password" placeholder="New Password" name="password"><br><br>
        <input type="password" placeholder="Password Confirmation" name="password_confirmation"><br><br>
        <input type="submit">
    </form>
</body>
</html>