<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>
<body>
    <h1>Đăng ký tài khoản</h1>
    <form id="registerForm">
        <div>
            <label>Username:</label>
            <input type="text" id="username">
        </div>
        <br>
        <div>
            <label>Email:</label>
            <input type="email" id="email">
        </div>
        <br>
        <div>
            <label>Mật khẩu:</label>
            <input type="password" id="password">
        </div>
        <br>
        <div>
            <label>Nhập lại mật khẩu:</label>
            <input type="password" id="confirmPassword">
        </div>
        <br>
        <button type="submit">
            Đăng ký
        </button>
    </form>
    <p id="message"></p>
    <script src="script.js"></script>
</body>
</html>