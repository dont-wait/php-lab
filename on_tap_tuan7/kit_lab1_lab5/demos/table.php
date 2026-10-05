<?php
require dirname(__DIR__).'/bootstrap.php';
require __DIR__.'/layout.php';
page('Table độc lập, không cần MySQL');
LabKit\table([['name' => 'Webcam', 'stock' => 12], ['name' => '<script>alert(1)</script>', 'stock' => 0]],
              ['name' => 'Tên thiết bị', 'stock' => 'Tồn kho']);
echo '<p>Chuỗi script phải hiển thị nguyên văn. Bảng rỗng:</p>';
LabKit\table([], ['name' => 'Tên', 'stock' => 'Tồn kho']);
endPage();
