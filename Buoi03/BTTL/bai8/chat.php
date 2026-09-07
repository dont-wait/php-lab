<?php
$file = 'chat.txt';
if (isset($_POST['msg'])) {
    file_put_contents($file, $_POST['msg'] . "\n", FILE_APPEND);
}
$messages = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
header('Content-Type: application/json');
echo json_encode($messages);
?>