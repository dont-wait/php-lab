<?php
require dirname(__DIR__).'/bootstrap.php';
require __DIR__.'/layout.php';
$error = '';
$saved = null;
if (LabKit\isPost()) {
    LabKit\requirePostCsrf();
    try { $saved = LabKit\upload(is_array($_FILES['file'] ?? null) ? $_FILES['file'] : []); }
    catch (InvalidArgumentException | RuntimeException $e) { $error = $e->getMessage(); }
}
page('Upload PNG/JPEG/PDF');
echo '<p>Dung lượng tối đa: '.LabKit\escape(LabKit\config()['upload_max_bytes']).' byte.</p>';
echo '<p>'.LabKit\escape($error).'</p>';
LabKit\form('upload.php', 'POST', ['file' => ['label' => 'File', 'type' => 'file', 'required' => true, 'accept' => '.png,.jpg,.jpeg,.pdf']], [], [], 'Upload');
if ($saved) {
    LabKit\table([$saved], ['key' => 'Tên lưu', 'mime' => 'MIME', 'size' => 'Byte']);
    echo '<p><a href="download.php?key='.rawurlencode($saved['key']).'">Tải file vừa lưu</a></p>';
}
endPage();
