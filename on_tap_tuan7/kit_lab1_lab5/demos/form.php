<?php
require dirname(__DIR__).'/bootstrap.php';
require __DIR__.'/layout.php';
use function LabKit\{text, isPost, requirePostCsrf, validate, form, table};
$values = ['name' => text($_POST, 'name'), 'email' => text($_POST, 'email')];
$errors = [];
if (isPost()) {
    requirePostCsrf();
    $errors = validate($values, ['name' => ['label' => 'Họ tên', 'required' => true, 'maxLength' => 100],
                               'email' => ['label' => 'Email', 'required' => true, 'email' => true]]);
}
page('Form POST, validation và CSRF');
form('form.php', 'POST', ['name' => ['label' => 'Họ tên', 'required' => true],
                        'email' => ['label' => 'Email', 'type' => 'email', 'required' => true]], $values, $errors);
if (isPost() && !$errors) table([$values], ['name' => 'Họ tên', 'email' => 'Email']);
endPage();
