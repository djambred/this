<h2>Hello {{ $user->name }},</h2>
<p>Thank you for registering. Here are your login credentials:</p>
<ul>
    <li>Email: {{ $user->email }}</li>
    <li>Password: {{ $password }}</li>
    <p>
    You can login here:
    <a href="{{ url('/bootcamp') }}" target="_blank">Login to your account</a>
    </p>
</ul>
<p>Please login and change your password after your first login.</p>
<p>Thank you for choosing our services!</p>
