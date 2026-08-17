<?php

$notePath = __DIR__.'/note.txt';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = trim($_POST['note'] ?? '');

    if ($note === '') {
        $message = 'Vui lòng nhập nội dung.';
    } else {
        $entry = $note.PHP_EOL;
        $written = file_put_contents($notePath, $entry, FILE_APPEND | LOCK_EX);

        if ($written === false) {
            $message = 'Không thể lưu nội dung vào file note.txt.';
        } else {
            $message = 'Đã lưu nội dung vào file note.txt.';
        }
    }
} else {
    $message = 'Hãy gửi nội dung từ form.';
}

$savedNotes = '';
if (file_exists($notePath)) {
    $content = file_get_contents($notePath);
    if ($content !== false) {
        $savedNotes = $content;
    }
}

echo '<p>'.htmlspecialchars($message).'</p>';
echo '<h3>Toàn bộ nội dung đã lưu</h3>';
echo '<pre>'.htmlspecialchars($savedNotes).'</pre>';
echo "<a href='note_form.html'>Quay lại</a>";
