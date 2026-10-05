<?php
require dirname(__DIR__).'/bootstrap.php';
require __DIR__.'/layout.php';
use function LabKit\{isPost, requirePostCsrf, text, login, logout, redirect, currentUser, form, escape, remember, forget, cookie};
$error = '';
if (isPost()) {
    requirePostCsrf();
    if (text($_POST, 'action') === 'logout') {
        logout(); forget('labkit_name'); redirect('auth.php');
    }
    // Tài khoản cố định chỉ để ôn session. Ứng dụng thật đọc password hash từ DB.
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    if (text($_POST, 'username') === 'demo' && password_verify($password, password_hash('123456', PASSWORD_DEFAULT))) {
        login(['id' => 1, 'name' => 'demo']);
        remember('labkit_name', 'demo'); redirect('auth.php');
    }
    $error = 'Sai tài khoản hoặc mật khẩu.';
}
page('Session, auth và cookie');
$user = currentUser();
if ($user) {
    echo '<p>Đang đăng nhập: '.escape($user['name']).'</p><form method="post" action="auth.php">'.LabKit\csrfField().'<input type="hidden" name="action" value="logout"><button>Đăng xuất</button></form>';
} else {
    echo '<p>Tài khoản luyện tập: demo / 123456</p><p>'.escape($error).'</p>';
    form('auth.php', 'POST', ['username' => ['label' => 'Tài khoản'], 'password' => ['label' => 'Mật khẩu', 'type' => 'password']], [], [], 'Đăng nhập');
}
echo '<p>Cookie ghi nhớ tên: '.escape(cookie('labkit_name')).'</p>';
endPage();
