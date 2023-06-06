<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Register</title>

    <style>
        /* Thiết lập các kiểu CSS cho email */
        /* Bạn có thể tùy chỉnh theo ý muốn */

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #dddddd;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        .message {
            padding: 20px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .message h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .message p {
            margin: 10px 0;
        }

        .footer {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="logo">
            <img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}" alt="Logo">
        </div>
        <div class="message">
            <h3>Xin chào!</h3>
            <p>Cảm ơn bạn đã đăng ký tài khoản thành công.</p>
            <p>Thông tin tài khoản của bạn:</p>
            <ul>
                <li><strong>Tên người dùng:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
            </ul>
        </div>
        <div class="footer">
            <p>Xin cảm ơn,</p>
            <p>Đội ngũ của chúng tôi.</p>
        </div>
    </div>
</body>

</html>
