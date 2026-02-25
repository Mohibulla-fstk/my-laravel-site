<!DOCTYPE html>
<html>
<head>
    <title>Password Reset OTP</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; text-align: center; }
        h2 { color: #333; }
        p { color: #555; }
        .otp { font-size: 24px; font-weight: bold; color: #000; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Hello {{ $user->name }},</h2>
        <p>Use the following OTP to reset your password:</p>
        <div class="otp">{{ $otp }}</div>
        <p>This OTP will expire in 2 minutes.</p>
    </div>
</body>
</html>
