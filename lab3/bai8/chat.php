<?php

$file = 'chat.txt';
if (isset($_POST['msg'])) {
    $message = trim($_POST['msg']);
    if ($message !== '') {
        file_put_contents($file, $message."\n", FILE_APPEND | LOCK_EX);
    }
}

$messages = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
header('Content-Type: application/json');
echo json_encode($messages);
