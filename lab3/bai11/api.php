<?php

header('Content-Type: application/json; charset=UTF-8');
$response = file_get_contents('https://open.er-api.com/v6/latest/USD');

if ($response === false) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Khong the lay du lieu ty gia',
    ]);
    exit;
}

$data = json_decode($response, true);
if (! $data || $data['result'] !== 'success') {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Du lieu ty gia khong hop le',
    ]);
    exit;
}

$currencies = ['VND', 'EUR', 'JPY', 'KRW', 'SGD'];
$rates = array_intersect_key($data['rates'], array_flip($currencies));

echo json_encode([
    'success' => true,
    'rates' => $rates,
    'time' => date('d/m/Y H:i:s'),
]);
