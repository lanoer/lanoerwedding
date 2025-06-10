<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
</head>

<body>
    <p>Halo {{ $user->name }},</p>
    <p>Password Anda telah direset oleh admin.</p>
    <p><strong>Password baru:</strong> {{ $newPassword }}</p>
    <p>Silakan login dan ganti password Anda segera.</p>
    <p>Terima kasih.</p>
</body>

</html>