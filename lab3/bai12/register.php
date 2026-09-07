<?php

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$username = trim($data['username'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if ($username === '' || $email === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Vui long nhap day du thong tin',
    ]);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'lab3_users');
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Khong the ket noi MySQL',
    ]);
    exit;
}

$stmt = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
$stmt->bind_param('ss', $username, $email);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Ten dang nhap hoac email da ton tai',
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->close();
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $username, $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Tao tai khoan thanh cong',
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Tao tai khoan that bai',
    ]);
}

$stmt->close();
$conn->close();
