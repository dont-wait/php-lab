<?php
// Kiểm tra component độc lập bằng SQLite trong bộ nhớ; không thay CSDL bài ôn.
session_save_path(sys_get_temp_dir());
require dirname(__DIR__).'/bootstrap.php';
use function LabKit\{escape, text, integer, validate, verifyCsrf, csrfToken, query, rows, row, scalar,
    containsPattern, allowedIdentifier, pagination, table, form, login, logout, currentUser,
    writeText, readText, writeJson, readJson, storagePath, upload};
$checks = 0;
function check(bool $condition, string $message): void
{
    global $checks;
    if (!$condition) throw new RuntimeException($message);
    $checks++;
}
check(escape('<script>"&') === '&lt;script&gt;&quot;&amp;', 'escape');
check(text(['x' => ['bad']], 'x') === '', 'array input');
check(text(['x' => '  Sang '], 'x') === 'Sang', 'trim');
check(integer(['x' => '0'], 'x', 8) === 0, 'zero integer');
check(integer(['x' => 'abc'], 'x', 8) === 8, 'invalid integer');
check(validate(['n' => '0'], ['n' => ['required' => true, 'integer' => true, 'min' => 0]]) === [], 'validation zero');
check(isset(validate(['n' => '1e999'], ['n' => ['number' => true]])['n']), 'infinite number');
check(isset(validate(['email' => 'abc'], ['email' => ['email' => true]])['email']), 'invalid email');
check(isset(validate(['n' => ['bad']], ['n' => ['required' => true]])['n']), 'validation array');
$rejectedRedirects = 0;
foreach ([' //example.com', '//example.com', 'https://example.com', "\nredirect", '\\redirect'] as $path) {
    try { LabKit\redirect($path); }
    catch (InvalidArgumentException $e) { $rejectedRedirects++; }
}
check($rejectedRedirects === 5, 'reject external/control redirects');
$token = csrfToken();
check(strlen($token) === 64 && verifyCsrf($token), 'valid CSRF');
check(!verifyCsrf('wrong') && !verifyCsrf(['bad']), 'invalid CSRF');
$db = new PDO('sqlite::memory:', null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$db->exec('CREATE TABLE items(id INTEGER PRIMARY KEY, name TEXT, price INTEGER)');
query($db, 'INSERT INTO items(name,price) VALUES (?,?)', ['Laptop', 100]);
query($db, 'INSERT INTO items(name,price) VALUES (:name,:price)', ['name' => '100%_kit', 'price' => 0]);
check((int) scalar($db, 'SELECT COUNT(*) FROM items') === 2, 'insert/scalar');
check(row($db, 'SELECT * FROM items WHERE id = ?', [999]) === null, 'missing row');
check(rows($db, 'SELECT * FROM items WHERE price >= :price LIMIT :limit OFFSET :offset', ['price' => 0, 'limit' => 1, 'offset' => 1])[0]['name'] === '100%_kit', 'bind LIMIT integer');
check(count(rows($db, 'SELECT * FROM items WHERE name = ?', ["' OR 1=1 --"])) === 0, 'SQL injection');
check(count(rows($db, "SELECT * FROM items WHERE name LIKE :q ESCAPE '!'", ['q' => containsPattern('%_')])) === 1, 'LIKE literal wildcard');
check(allowedIdentifier('id DESC; DROP TABLE items', ['id', 'name'], 'id') === 'id', 'sort allowlist');
check(pagination(7, 99, 3)['page'] === 3 && pagination(7, 99, 3)['offset'] === 6, 'page clamp');
check(pagination(0, -1, 3)['pages'] === 1, 'empty pagination');
ob_start(); table([['name' => '<script>']], ['name' => 'Tên']); $html = ob_get_clean();
check(str_contains($html, '&lt;script&gt;') && !str_contains($html, '<script>'), 'table escape');
ob_start(); table([], ['name' => 'Tên']); $html = ob_get_clean();
check(str_contains($html, 'Không có dữ liệu'), 'empty table');
ob_start(); form('form.php', 'POST', ['name' => ['label' => 'Tên']], ['name' => '" autofocus']); $html = ob_get_clean();
check(str_contains($html, 'name="_csrf"') && str_contains($html, '&quot; autofocus'), 'form CSRF/escape');
login(['id' => 1, 'name' => 'demo']);
check(currentUser()['id'] === 1 && !verifyCsrf($token), 'login rotates token');
logout(); check(currentUser() === null, 'logout');
$prefix = 'test-'.bin2hex(random_bytes(8));
try {
    writeText($prefix.'.txt', 'A'); writeText($prefix.'.txt', 'B', true);
    check(readText($prefix.'.txt') === 'AB', 'text append');
    writeJson($prefix.'.json', ['name' => 'Tiếng Việt']);
    check(readJson($prefix.'.json')['name'] === 'Tiếng Việt', 'JSON roundtrip');
    try { storagePath('../secret'); check(false, 'path traversal'); }
    catch (InvalidArgumentException $e) { check(true, 'path rejected'); }
    try { upload(['error' => UPLOAD_ERR_NO_FILE]); check(false, 'empty upload'); }
    catch (InvalidArgumentException $e) { check(true, 'upload rejected'); }
} finally {
    foreach (['txt', 'json'] as $extension) {
        $path = storagePath($prefix.'.'.$extension);
        if (is_file($path)) unlink($path); // Chỉ xóa file thử có tên random do test tạo.
    }
}
echo "PASS: $checks kiểm tra component. MySQL/HTTP/upload thật kiểm tra riêng.\n";
