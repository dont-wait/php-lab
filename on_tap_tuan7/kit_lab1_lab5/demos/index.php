<?php
require dirname(__DIR__).'/bootstrap.php';
require __DIR__.'/layout.php';
page('Kit PHP Lab 1–5');
$links = ['form.php' => 'Form + validation + CSRF', 'table.php' => 'Table dùng dữ liệu mẫu',
          'query.php' => 'PDO + search/sort/pagination', 'api_demo.php' => 'Fetch + JSON API',
          'auth.php' => 'Session/login/logout/cookie', 'storage.php' => 'Ghi chú + file JSON',
          'upload.php' => 'Upload + download'];
echo '<ul>';
foreach ($links as $url => $label) echo '<li><a href="'.LabKit\escape($url).'">'.LabKit\escape($label).'</a></li>';
echo '</ul><p>Demo query/API đọc week7_device. Các demo còn lại không cần MySQL.</p>';
endPage();
