<?php
// Import một lần; namespace LabKit tránh trùng tên với helper của bài làm.
foreach (['request', 'response', 'validation', 'security', 'connect', 'query',
          'form', 'table', 'pagination', 'auth', 'storage', 'upload'] as $component) {
    require_once __DIR__.'/components/'.$component.'.php';
}
// Khởi động trước khi demo xuất HTML để session/cookie/CSRF hoạt động.
LabKit\startSession();
