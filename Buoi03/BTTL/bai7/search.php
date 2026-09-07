<?php
$keyword = strtolower($_GET['q'] ?? '');
$products = [
    ["name" => "Iphone 15", "price" => 30000000],
    ["name" => "Samsung S24", "price" => 25000000]
];
$result = array_filter($products, fn($p) => strpos(
    strtolower($p['name']),
    $keyword
) !== false);
header('Content-Type: application/json');
echo json_encode(array_values($result));
?>