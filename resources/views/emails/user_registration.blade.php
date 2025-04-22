<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Your Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-top: 0;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 3px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666666;
        }

        .warning {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome, {{ $name }}!</h1>

        <p>Your account has been successfully created. Here are your login details:</p>

        <ul>
            <li>Email: {{ $email }}</li>
            <li>Password: {{ $password }}</li>
            <li>Your Domain: <a href="http://{{ $subdomain }}">http://{{ $subdomain }}</a></li>
        </ul>

        <p class="warning">Please keep this information safe and secure. We recommend changing your password after your
            first login.</p>

        <p>Thank you for registering!</p>

        <div class="footer">
            <p>Best regards,<br>
                Your Application Team</p>
        </div>
    </div>
</body>

</html>
