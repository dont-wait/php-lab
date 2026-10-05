<?php
require dirname(__DIR__).'/bootstrap.php';
$key = LabKit\text($_GET, 'key');
if (!preg_match('/^[a-f0-9]{32}\.(png|jpg|pdf)$/D', $key)) LabKit\abort(400, 'Key upload không hợp lệ.');
$path = LabKit\storagePath($key);
if (!is_file($path)) LabKit\abort(404, 'File không tồn tại.');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$key.'"');
header('X-Content-Type-Options: nosniff');
header('Content-Length: '.filesize($path));
session_write_close();
readfile($path);
