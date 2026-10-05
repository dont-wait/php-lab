<?php
// Câu 1.2 — tạo đối tượng: Ref lab2/bai2.php.
require __DIR__.'/Device.php';
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Câu 1.2 — Device</title></head>
<body>
<h1>Câu 1.2 — Device</h1>
<?php
$device1 = new Device('Laptop Dell Latitude', 18500000, 8);
$device2 = new Device('Laptop Dell Inpiron 15', 20000000, 1);
$device1->showInfo();
$device2->showInfo();
?>
</body>
</html>
