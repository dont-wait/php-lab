<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dang ky thanh vien</title>
</head>

<body>
    <h1>Tao tai khoan hoc vien</h1>
    <form id="registerForm">
        <div>
            <label for="username">Ten dang nhap:</label>
            <input type="text" id="username">
        </div>
        <br>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email">
        </div>
        <br>
        <div>
            <label for="password">Mat khau:</label>
            <input type="password" id="password">
        </div>
        <br>
        <div>
            <label for="confirmPassword">Nhap lai mat khau:</label>
            <input type="password" id="confirmPassword">
        </div>
        <br>
        <button type="submit">Dang ky</button>
    </form>
    <p id="message"></p>

    <script src="index.js"></script>
</body>

</html>
