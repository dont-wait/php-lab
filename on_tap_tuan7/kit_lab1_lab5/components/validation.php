<?php
namespace LabKit;
// Lab 1 validation; Lab 4 student_helpers.php. Trả lỗi theo key của field.
function validate(array $data, array $rules): array
{
    $errors = [];
    foreach ($rules as $key => $rule) {
        $value = $data[$key] ?? '';
        $label = $rule['label'] ?? $key;
        if (!is_string($value) && !is_int($value) && !is_float($value)) {
            $errors[$key] = "$label phải là giá trị đơn."; continue;
        }
        $value = trim((string) $value);
        if ($value === '') {
            if ($rule['required'] ?? false) $errors[$key] = "$label bắt buộc nhập.";
            continue;
        }
        if (($rule['email'] ?? false) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[$key] = "$label không đúng định dạng email.";
        } elseif (($rule['integer'] ?? false) && filter_var($value, FILTER_VALIDATE_INT) === false) {
            $errors[$key] = "$label phải là số nguyên.";
        } elseif (($rule['number'] ?? false) || ($rule['integer'] ?? false)) {
            if (!is_numeric($value) || !is_finite((float) $value)) $errors[$key] = "$label phải là số hữu hạn.";
            elseif (isset($rule['min']) && (float) $value < $rule['min']) $errors[$key] = "$label phải từ {$rule['min']} trở lên.";
            elseif (isset($rule['max']) && (float) $value > $rule['max']) $errors[$key] = "$label phải không quá {$rule['max']}.";
        }
        if (!isset($errors[$key]) && isset($rule['maxLength']) && mb_strlen($value, 'UTF-8') > $rule['maxLength']) {
            $errors[$key] = "$label tối đa {$rule['maxLength']} ký tự.";
        }
    }
    return $errors;
}
