<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
                    <!-- Header / Logo -->
                    <tr>
                        <td style="background-color: #2c3e50; padding: 20px;" align="center">
                            <img src="{{ webLogo()->logo_email }}" alt="Logo" style="display: block; height: 50px;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333;">Password Anda telah direset</h2>
                            <p>Berikut adalah informasi akun Anda:</p>
                            <p><strong>Email:</strong> {{ $email }}</p>
                            <p><strong>Password baru:</strong> {{ $password }}</p>

                            <p>Silakan login menggunakan tombol di bawah ini:</p>
                            <p style="text-align: center;">
                                <a href="{{ $url }}"
                                    style="display: inline-block; background-color: #3498db; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                    Login Sekarang
                                </a>
                            </p>

                            <p style="color: #999;">Jika Anda tidak meminta reset ini, silakan abaikan email ini.</p>

                            <p>Terima kasih,<br>{{ webInfo()->web_name }}</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #ecf0f1; padding: 20px; text-align: center; font-size: 12px; color: #666;">
                            <p>&copy; {{ date('Y') }} {{ webInfo()->web_name }}. All rights reserved.</p>
                            <p>
                                <a href="{{ webSosmed()->facebook }}" style="margin: 0 8px;">
                                    <img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook">
                                </a>
                                <a href="{{ webSosmed()->twitter }}" style="margin: 0 8px;">
                                    <img src="https://cdn-icons-png.flaticon.com/24/733/733579.png" alt="Twitter">
                                </a>
                                <a href="{{ webSosmed()->instagram }}" style="margin: 0 8px;">
                                    <img src="https://cdn-icons-png.flaticon.com/24/2111/2111463.png" alt="Instagram">
                                </a>
                                <a href="{{ webSosmed()->tiktok }}" style="margin: 0 8px;">
                                    <img src="https://cdn-icons-png.flaticon.com/24/3046/3046121.png" alt="TikTok">
                                </a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>