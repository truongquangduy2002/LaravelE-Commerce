<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>

<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
            <td align="center">
                <h2>Đặt lại mật khẩu</h2>
            </td>
        </tr>
        <tr>
            <td>
                <p>Xin chào.</p>
                <p>Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
                <p>Vui lòng nhấp vào nút bên dưới để tiến hành đặt lại mật khẩu:</p>
                <div style="text-align: center">
                    <p>
                        <a href="{{ $resetUrl }}"
                            style="display: inline-block; padding: 10px 20px; background-color: #2196F3; color: #ffffff; text-decoration: none;">Đặt
                            lại mật khẩu</a>
                    </p>
                </div>
                <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
                <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
            </td>
        </tr>
    </table>
</body>

</html>
