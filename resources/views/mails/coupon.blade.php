<!DOCTYPE html>
<html>

<head>
    <title>Thông báo Coupon</title>
</head>

<body>
    <style>
        h1 {
            text-align: center;
            font-size: 30px;
        }
        .bold {
            font: bold;
        }
    </style>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
            <td align="center">
                <!-- Logo của trang web -->
                <div style="display: flex; justify-content: center;">
                    <img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}" alt="Logo" width="200px">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <h1>Thông báo Voucher</h1>
                <p>Xin chào <strong class="bold">{{ $user->name }}</strong></p>
                <p>Bạn vừa nhận được một Voucher giảm giá từ chúng tôi.</p>
                <p>Thông tin voucher:</p>
                <ul>
                    <li>Mã voucher: {{ $coupon->coupon_name }}</li>
                    <li>Giá trị: {{ $coupon->coupon_discount }}</li>
                    <li>Thời gian: {{ $coupon->coupon_validity }}</li>
                </ul>
                <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
            </td>
        </tr>
    </table>
</body>

</html>
