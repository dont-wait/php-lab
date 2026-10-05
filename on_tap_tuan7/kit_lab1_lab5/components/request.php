<?php
namespace LabKit;
// Lab 1 form; Lab 3 bai12/register.php đọc JSON.
function text(array $source, string $key, string $default = ''): string
{
    return is_string($source[$key] ?? null) ? trim($source[$key]) : $default;
}
function integer(array $source, string $key, int $default = 0): int
{
    $value = filter_var($source[$key] ?? null, FILTER_VALIDATE_INT);
    return $value === false || $value === null ? $default : $value;
}
function isPost(): bool { return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'; }
function jsonBody(): array
{
    $value = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($value)) throw new \InvalidArgumentException('JSON phải là object hoặc array.');
    return $value;
}
