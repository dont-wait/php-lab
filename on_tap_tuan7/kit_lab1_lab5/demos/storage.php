<?php
require dirname(__DIR__).'/bootstrap.php';
require __DIR__.'/layout.php';
use function LabKit\{isPost, requirePostCsrf, text, validate, writeText, readText, writeJson, readJson, form, table, escape};
$error = '';
$content = '';
$meta = [];
try {
    if (isPost()) {
        requirePostCsrf();
        $note = text($_POST, 'note');
        $errors = validate(['note' => $note], ['note' => ['required' => true, 'maxLength' => 1000]]);
        if ($errors) $error = implode(' ', $errors);
        else {
            writeText('demo-notes.txt', $note.PHP_EOL, true);
            writeJson('demo-meta.json', ['last_note' => $note, 'saved_at' => date('c')]);
        }
    }
    $content = readText('demo-notes.txt');
    $meta = readJson('demo-meta.json');
} catch (RuntimeException | JsonException $e) { $error = 'Không đọc/ghi được file trong storage.'; }
page('File text và JSON');
echo '<p>'.escape($error).'</p>';
form('storage.php', 'POST', ['note' => ['label' => 'Ghi chú', 'type' => 'textarea', 'required' => true]]);
echo '<pre>'.escape($content).'</pre>';
if ($meta) table([$meta], ['last_note' => 'Ghi chú gần nhất', 'saved_at' => 'Thời gian']);
endPage();
