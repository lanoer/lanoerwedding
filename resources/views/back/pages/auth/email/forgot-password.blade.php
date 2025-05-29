<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - {{ webInfo()->web_name}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Basic styling for email --}}
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            padding: 0;
            margin: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .email-header {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
        }

        .email-header img {
            height: 40px;
        }

        .email-body {
            padding: 30px;
        }

        .email-body h2 {
            color: #212529;
            margin-top: 0;
        }

        .email-body p {
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white !important;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .email-footer {
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            background-color: #f1f3f5;
        }

        .text-muted {
            color: #6c757d !important;
        }
    </style>
</head>

<body>

    <div class="email-container">
        {{-- Header with logo --}}
        <div class="email-header">
            <img src="{{ webLogo()->logo_email }}" alt="{{ webInfo()->web_name}} Logo">
        </div>

        {{-- Main email content --}}
        <div class="email-body">
            <h2>Password Reset Request</h2>

            <p>Hello,</p>

            <p>You have requested to reset your password for your <strong>{{ webInfo()->web_name}}</strong> account.</p>

            <p>Click the button below to reset your password:</p>

            <p>
                <a href="{{ $url }}" class="btn">Reset Password</a>
            </p>

            <p class="text-muted">
                This password reset link will expire in 60 minutes.<br>
                If you did not request a password reset, no further action is required.
            </p>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            &copy; {{ date('Y') }} {{ webInfo()->web_name}}. All rights reserved.
        </div>
    </div>

</body>

</html>