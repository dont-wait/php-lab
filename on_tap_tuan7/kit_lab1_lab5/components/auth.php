<?php
namespace LabKit;
// Lab 1 bài 13/14/20. Login nhận user đã xác thực, không tự so password trong helper.
function startSession(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) return;
    if (headers_sent()) throw new \RuntimeException('Phải mở session trước khi xuất HTML.');
    session_name('LABKIT_SESSION');
    session_start(['use_strict_mode' => true, 'cookie_httponly' => true,
                   'cookie_samesite' => 'Lax', 'cookie_secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
}
function login(array $user): void
{
    startSession();
    session_regenerate_id(true);
    $_SESSION['labkit_user'] = $user;
    unset($_SESSION['labkit_csrf']);
}
function currentUser(): ?array { startSession(); return $_SESSION['labkit_user'] ?? null; }
function logout(): void
{
    startSession();
    unset($_SESSION['labkit_user'], $_SESSION['labkit_csrf']);
    session_regenerate_id(true);
}
function requireLogin(): array
{
    return currentUser() ?? abort(401, 'Cần đăng nhập.');
}
function remember(string $name, string $value, int $seconds = 3600): void
{
    setcookie($name, $value, ['expires' => time() + $seconds, 'path' => '/',
        'httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
}
function forget(string $name): void { remember($name, '', -3600); }
function cookie(string $name): string { return text($_COOKIE, $name); }
