<?php
header("Content-Type: application/json");
$data = json_decode(
    file_get_contents("php://input"),
    true
);

$username = trim($data["username"] ?? "");
$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";

if (
    $username === "" ||
    $email === "" ||
    $password === ""
) {
    echo json_encode([
        "success" => false,
        "message" => "Vui lòng nhập đầy đủ thông tin."
    ]);

    exit;
}

$host = "localhost";
$dbname = "user_db";
$dbuser = "root";
$dbpassword = "";

$conn = new mysqli(
    $host,
    $dbuser,
    $dbpassword,
    $dbname
);

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Không thể kết nối MySQL."
    ]);

    exit;
}

$sql = "
    SELECT id
    FROM users
    WHERE username = ? OR email = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ss",
    $username,
    $email
);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Username hoặc email đã tồn tại."
    ]);
    return;
}

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$sql = "
    INSERT INTO users (
        username,
        email,
        password
    )
    VALUES (?, ?, ?)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sss",
    $username,
    $email,
    $hashedPassword
);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Đăng ký thành công!"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Đăng ký thất bại."
    ]);
}

$stmt->close();
$conn->close();