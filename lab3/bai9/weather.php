<?php

$city = strtolower(trim($_GET['city'] ?? ''));
$data = [
    'hue' => ['temp' => 29, 'desc' => 'Troi nang nhe'],
    'dalat' => ['temp' => 20, 'desc' => 'Se lanh'],
    'cantho' => ['temp' => 31, 'desc' => 'Co may'],
];

header('Content-Type: application/json');
echo json_encode($data[$city] ?? [
    'temp' => 0,
    'desc' => 'Khong co du lieu',
]);
