<!DOCTYPE html>
<html>
<head>
    <title>Registration Confirmation</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Thank you for registering with us. Please click the link below to confirm your email address:</p>
    <a href="{{ url('confirmation-link', ['email' => $user->email]) }}">Confirm Email</a>
    <p>If you did not create an account, no further action is required.</p>
</body>
</html>
