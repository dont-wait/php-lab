<?php
header("Content-Type: application/json; charset=UTF-8");
$apiUrl = "https://open.er-api.com/v6/latest/USD";

$response = file_get_contents($apiUrl);

if ($response === false) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Không thể lấy dữ liệu tỷ giá"
    ]);
    return;
}

$data = json_decode($response, true);

if (!$data || $data["result"] !== "success") {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Dữ liệu tỷ giá không hợp lệ"
    ]);
    return;
}

echo json_encode([
    "success" => true,
    "base" => $data["base_code"],
    "rates" => $data["rates"],
    "time" => date("Y-m-d H:i:s")
]);