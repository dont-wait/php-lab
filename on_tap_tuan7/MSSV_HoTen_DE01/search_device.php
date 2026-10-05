<?php
// Câu 2.1 — Ghép Lab 3 Fetch/JSON với Lab 4 PDO/LIKE/Prepared Statement.
// Ref: lab3/bai7/search.php; lab4/bai1/list_students.php.
require __DIR__.'/helpers.php';
$keyword = inputText($_GET, 'keyword');
$maxPrice = inputText($_GET, 'max_price');
if ((isset($_GET['keyword']) && !is_string($_GET['keyword'])) ||
    (isset($_GET['max_price']) && !is_string($_GET['max_price']))) {
    jsonResponse(['error' => 'Tham số phải là chuỗi.'], 400);
}
if ($maxPrice !== '' && (!is_numeric($maxPrice) || !is_finite((float) $maxPrice) || (float) $maxPrice < 0)) {
    jsonResponse(['error' => 'Giá tối đa phải là số không âm.'], 400);
}
try {
    require __DIR__.'/connect.php';
    $sql = 'SELECT device_id, device_name, category, price, stock FROM devices WHERE device_name LIKE :keyword';
    // Escape wildcard để keyword chứa % hoặc _ vẫn được tìm như ký tự thông thường.
    $sql .= " ESCAPE '!'";
    $params = ['keyword' => '%'.strtr($keyword, ['!' => '!!', '%' => '!%', '_' => '!_']).'%'];
    if ($maxPrice !== '') {
        $sql .= ' AND price <= :max_price';
        $params['max_price'] = $maxPrice; // Không dùng empty(): giá 0 vẫn là bộ lọc hợp lệ.
    }
    $stmt = $conn->prepare($sql.' ORDER BY device_id');
    $stmt->execute($params);
    jsonResponse($stmt->fetchAll());
} catch (PDOException $e) {
    jsonResponse(['error' => 'Không thể tìm thiết bị. Kiểm tra cấu hình MySQL.'], 500);
}
