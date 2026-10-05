<?php
// Lab 4 connect.php; sửa các giá trị này khi chuyển sang máy khác.
return [
    'database' => ['host' => '127.0.0.1', 'port' => 3306, 'name' => 'week7_device',
                   'username' => 'root', 'password' => 'sa123'],
    // Đặt ngoài thư mục web để file upload không thể chạy như PHP.
    'storage' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'php-lab-kit',
    'upload_max_bytes' => 2 * 1024 * 1024,
];
