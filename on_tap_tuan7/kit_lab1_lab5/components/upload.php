<?php
namespace LabKit;
// Lab 1 bài 11/15; kit bổ sung MIME thật, giới hạn dung lượng và tên random.
function upload(array $file, array $allowedMime = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'application/pdf' => 'pdf']): array
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) throw new \InvalidArgumentException('Upload thất bại hoặc chưa chọn file.');
    $tmp = $file['tmp_name'] ?? null;
    if (!is_string($tmp) || !is_uploaded_file($tmp)) throw new \InvalidArgumentException('File không phải upload HTTP.');
    $size = filesize($tmp);
    if ($size === false || $size < 1 || $size > config()['upload_max_bytes']) throw new \InvalidArgumentException('File rỗng hoặc vượt dung lượng cho phép.');
    $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($tmp);
    $extension = $allowedMime[$mime] ?? null;
    if (!is_string($extension) || !preg_match('/^[a-z0-9]+$/D', $extension)) throw new \InvalidArgumentException('Loại file không được phép.');
    $key = bin2hex(random_bytes(16)).'.'.$extension;
    if (!move_uploaded_file($tmp, storagePath($key))) throw new \RuntimeException('Không lưu được upload.');
    return ['key' => $key, 'mime' => $mime, 'size' => $size];
}
