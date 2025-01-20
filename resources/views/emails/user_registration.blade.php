<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multitenancy Quiz Management</title>
</head>
<body>
    <h1>Welcome, {{ $data['name'] }}!</h1>
    <p>Thank you for registering with us. We are excited to have you on board!</p>
    <p>your dashboard link is: <a href="{{ $data['domain'] }}">{{ $data['domain'] }}</a></p>
    <p>your Admin Email: {{ $data['email'] }}</p>
    <p>your Admin Password: {{ $data['password'] }}</p>
    <p>Best Regards, 
</body>
</html>