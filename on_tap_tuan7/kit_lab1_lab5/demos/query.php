<?php
require dirname(__DIR__).'/bootstrap.php';
require __DIR__.'/layout.php';
use function LabKit\{db, text, integer, scalar, rows, containsPattern, allowedIdentifier, pagination, paginationLinks, form, table};
$keyword = text($_GET, 'keyword');
$sort = allowedIdentifier(text($_GET, 'sort'), ['device_id', 'device_name', 'price', 'stock'], 'device_id');
$error = '';
$devices = [];
try {
    $params = ['keyword' => containsPattern($keyword)];
    $where = "WHERE device_name LIKE :keyword ESCAPE '!'";
    $total = (int) scalar(db(), 'SELECT COUNT(*) FROM devices '.$where, $params);
    $paging = pagination($total, integer($_GET, 'page', 1), 3);
    $devices = rows(db(), "SELECT device_id, device_name, price, stock FROM devices $where ORDER BY $sort ASC, device_id ASC LIMIT :limit OFFSET :offset",
                    $params + ['limit' => $paging['limit'], 'offset' => $paging['offset']]);
} catch (PDOException $e) {
    http_response_code(500);
    $error = 'Không đọc được MySQL. Kiểm tra config.php và import schema.';
}
page('PDO, search, sort, pagination');
form('query.php', 'GET', ['keyword' => ['label' => 'Tên chứa'],
    'sort' => ['label' => 'Sắp xếp', 'type' => 'select', 'options' => ['device_id' => 'ID', 'device_name' => 'Tên', 'price' => 'Giá', 'stock' => 'Tồn kho']]],
    ['keyword' => $keyword, 'sort' => $sort], [], 'Lọc');
if ($error !== '') echo '<p>'.LabKit\escape($error).'</p>';
else {
    table($devices, ['device_id' => 'ID', 'device_name' => 'Tên', 'price' => 'Giá', 'stock' => 'Tồn kho']);
    paginationLinks($paging, ['keyword' => $keyword, 'sort' => $sort]);
}
endPage();
