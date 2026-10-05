<?php
namespace LabKit;
// Lab 1 bài 12/19, Lab 3 JSON file. Chỉ nhận key đơn, không nhận đường dẫn từ request.
function storagePath(string $key): string
{
    if (!preg_match('/^[A-Za-z0-9][A-Za-z0-9_.-]*$/D', $key)) throw new \InvalidArgumentException('Tên file không hợp lệ.');
    $directory = config()['storage'];
    if (!is_dir($directory) && !mkdir($directory, 0700, true) && !is_dir($directory)) {
        throw new \RuntimeException('Không tạo được thư mục lưu trữ.');
    }
    $path = $directory.DIRECTORY_SEPARATOR.$key;
    if (is_link($path)) throw new \RuntimeException('Không dùng file symlink.');
    return $path;
}
function writeText(string $key, string $text, bool $append = false): void
{
    if (file_put_contents(storagePath($key), $text, LOCK_EX | ($append ? FILE_APPEND : 0)) === false) {
        throw new \RuntimeException('Không ghi được file.');
    }
}
function readText(string $key, string $default = ''): string
{
    $path = storagePath($key);
    if (!is_file($path)) return $default;
    $content = file_get_contents($path);
    if ($content === false) throw new \RuntimeException('Không đọc được file.');
    return $content;
}
function writeJson(string $key, array $data): void
{
    writeText($key, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
}
function readJson(string $key, array $default = []): array
{
    $text = readText($key);
    if ($text === '') return $default;
    $data = json_decode($text, true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($data)) throw new \RuntimeException('File JSON phải chứa array/object.');
    return $data;
}
