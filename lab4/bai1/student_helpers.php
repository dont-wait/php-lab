<?php

function escape($value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function studentInput(): array
{
    $data = [];
    foreach (['name', 'email', 'phone', 'birthday'] as $field) {
        $data[$field] = is_string($_POST[$field] ?? null) ? trim($_POST[$field]) : '';
    }

    return $data;
}

function studentErrors(array $data): array
{
    $errors = [];
    if ($data['name'] === '' || mb_strlen($data['name']) > 100) {
        $errors[] = 'Họ tên bắt buộc nhập và tối đa 100 ký tự.';
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 100) {
        $errors[] = 'Email không hợp lệ hoặc dài quá 100 ký tự.';
    }
    if (mb_strlen($data['phone']) > 20) {
        $errors[] = 'Số điện thoại tối đa 20 ký tự.';
    }
    if ($data['birthday'] !== '') {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $data['birthday']);
        if (!$date || $date->format('Y-m-d') !== $data['birthday'] || $date > new DateTimeImmutable('today')) {
            $errors[] = 'Ngày sinh không hợp lệ hoặc nằm trong tương lai.';
        }
    }

    return $errors;
}
