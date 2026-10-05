<?php
namespace LabKit;
// Lab 3 JSON; Lab 1 redirect sau lưu cookie/login.
function json($data, int $status = 200): never
{
    // Encode trước khi đặt header, để lỗi encode không gửi nhầm response thành công.
    $body = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    if (session_status() === PHP_SESSION_ACTIVE) session_write_close();
    echo $body;
    exit;
}
function redirect(string $path, int $status = 303): never
{
    if ($path === '' || preg_match('/[\x00-\x20\x7f]/', $path) || str_contains($path, '\\') || str_starts_with($path, '//') ||
        preg_match('/^[a-z][a-z0-9+.-]*:/i', $path)) {
        throw new \InvalidArgumentException('Chỉ chuyển hướng đường dẫn nội bộ.');
    }
    header('Location: '.$path, true, $status);
    exit;
}
function abort(int $status, string $message): never
{
    http_response_code($status);
    header('Content-Type: text/plain; charset=utf-8');
    echo $message;
    exit;
}
