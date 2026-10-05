<?php
namespace LabKit;
// Escape: Lab 1/4. CSRF là phần mở rộng của kit, không có mẫu đầy đủ trong lab gốc.
function escape($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function csrfToken(): string
{
    startSession();
    return $_SESSION['labkit_csrf'] ??= bin2hex(random_bytes(32));
}
function csrfField(): string
{
    return '<input type="hidden" name="_csrf" value="'.escape(csrfToken()).'">';
}
function verifyCsrf($token): bool
{
    startSession();
    return is_string($token) && isset($_SESSION['labkit_csrf']) && hash_equals($_SESSION['labkit_csrf'], $token);
}
function requirePostCsrf(): void
{
    if (!isPost()) { header('Allow: POST'); abort(405, 'Phải gửi POST.'); }
    if (!verifyCsrf($_POST['_csrf'] ?? null)) abort(403, 'CSRF token không hợp lệ.');
}
