<?php
// Câu 1.2 — Ref: lab2/bai2.php.
require __DIR__.'/Workshop.php';
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Câu 1.2 — Workshop</title></head>
<body>
<h1>Câu 1.2 — Workshop</h1>
<?php
$workshop = new Workshop('PHP Web Basics', 350000, 25);
$workshop->showInfo();
echo 'Sau giảm 10%: '.number_format($workshop->getDiscountedFee(10), 0, ',', '.').' đồng';
?>
</body>
</html>
