<?php

$keyword = strtolower($_GET['q'] ?? '');
$products = [
    ['name' => 'Laptop Asus Vivobook', 'price' => 15990000],
    ['name' => 'Chuot Logitech M331', 'price' => 350000],
    ['name' => 'Ban phim Akko 5075B', 'price' => 1890000],
];
$result = array_filter($products,
    fn ($p) => strpos(strtolower($p['name']), $keyword) !== false
);
header('Content-Type: application/json');
echo json_encode(array_values($result));
