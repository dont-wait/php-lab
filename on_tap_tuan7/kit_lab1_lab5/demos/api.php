<?php
require dirname(__DIR__).'/bootstrap.php';
use function LabKit\{isPost, verifyCsrf, jsonBody, json, text, validate, rows, db, containsPattern};
try {
    if (isPost()) {
        if (!verifyCsrf($_SERVER['HTTP_X_CSRF_TOKEN'] ?? null)) json(['error' => 'CSRF token không hợp lệ.'], 403);
        $data = jsonBody();
        $errors = validate($data, ['name' => ['required' => true, 'maxLength' => 100]]);
        if ($errors) json(['errors' => $errors], 422);
        json(['message' => 'Đã nhận JSON', 'name' => text($data, 'name')]);
    }
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
        header('Allow: GET, POST'); json(['error' => 'Method không được hỗ trợ.'], 405);
    }
    $devices = rows(db(), "SELECT device_id, device_name, price FROM devices WHERE device_name LIKE :keyword ESCAPE '!' ORDER BY device_id",
        ['keyword' => containsPattern(text($_GET, 'keyword'))]);
    json($devices);
} catch (JsonException | InvalidArgumentException $e) {
    json(['error' => 'JSON/đầu vào không hợp lệ.'], 400);
} catch (PDOException $e) {
    json(['error' => 'Không đọc được CSDL.'], 500);
}
