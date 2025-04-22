<h2>Welcome!</h2>
<p>Your account has been created successfully.</p>
<ul>
    <li><strong>Account Name:</strong> {{ $details['accountName'] }}</li>
    <li><strong>Password:</strong> {{ $details['password'] }}</li>
    <li><strong>Subdomain Link:</strong> <a href="http://{{ $details['subdomain'] }}">{{ $details['subdomain'] }}</a>
    </li>
</ul>
<p>You can now start using your subdomain!</p>
