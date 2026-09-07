<?php
$name = $_POST['name'] ?? 'Bạn';
echo "Xin chào, " . htmlspecialchars($name);
?>