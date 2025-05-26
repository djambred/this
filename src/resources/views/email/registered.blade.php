<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Bootcamp</title>
</head>
<body>
    <h2>Hi {{ $user->name }},</h2>
    <p>You're successfully registered to the Bootcamp.</p>

    <p>Here are your login credentials:</p>

    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p>Login at: <a href="{{ url('/login') }}">{{ url('/login') }}</a></p>

    <p>Thanks,<br>The Bootcamp Team</p>
</body>
</html>
