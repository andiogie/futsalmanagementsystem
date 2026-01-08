<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - FutsalGo</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" style="background:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="background:#16a34a; color:white; text-align:center; padding:20px;">
                            <h1 style="margin:0;">FutsalGo</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px; color:#333;">
                            <h2>Halo, {{ $user->name }}</h2>
                            <p>Kami menerima permintaan untuk mereset password akun Anda.</p>
                            <p>Silakan klik tombol di bawah ini untuk mengatur ulang password:</p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="{{ $resetUrl }}"
                                   style="background:#16a34a; color:white; text-decoration:none; padding:12px 24px; border-radius:5px; font-size:16px;">
                                    Reset Password
                                </a>
                            </p>

                            <p>Link ini hanya berlaku selama <strong>60 menit</strong>.</p>

                            <p>Jika Anda tidak merasa meminta reset password, abaikan email ini.</p>

                            <br>
                            <p>Salam hangat,</p>
                            <p><strong>Tim FutsalGo</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f3f3f3; text-align:center; padding:15px; font-size:12px; color:#777;">
                            © {{ date('Y') }} FutsalGo. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
