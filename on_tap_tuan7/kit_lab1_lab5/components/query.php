<?php
namespace LabKit;
// Lab 4 list_students.php: mọi giá trị đầu vào đi qua placeholder.
function query(\PDO $connection, string $sql, array $params = []): \PDOStatement
{
    $stmt = $connection->prepare($sql);
    foreach ($params as $key => $value) {
        $placeholder = is_int($key) ? $key + 1 : ':'.ltrim($key, ':');
        $type = match (true) {
            is_int($value) => \PDO::PARAM_INT,
            is_bool($value) => \PDO::PARAM_BOOL,
            $value === null => \PDO::PARAM_NULL,
            default => \PDO::PARAM_STR,
        };
        $stmt->bindValue($placeholder, $value, $type);
    }
    $stmt->execute();
    return $stmt;
}
function rows(\PDO $connection, string $sql, array $params = []): array
{
    return query($connection, $sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
}
function row(\PDO $connection, string $sql, array $params = []): ?array
{
    return query($connection, $sql, $params)->fetch(\PDO::FETCH_ASSOC) ?: null;
}
function scalar(\PDO $connection, string $sql, array $params = [])
{
    return query($connection, $sql, $params)->fetchColumn();
}
// Tên bảng/cột không bind được: chỉ lấy từ allowlist cố định do người viết code cung cấp.
function allowedIdentifier(string $input, array $allowed, string $fallback): string
{
    if (!in_array($fallback, $allowed, true)) throw new \InvalidArgumentException('Fallback phải thuộc allowlist.');
    $value = in_array($input, $allowed, true) ? $input : $fallback;
    if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $value)) throw new \InvalidArgumentException('Tên cột không hợp lệ.');
    return $value;
}
function containsPattern(string $keyword): string
{
    // SQL dùng LIKE :keyword ESCAPE '!'.
    return '%'.strtr($keyword, ['!' => '!!', '%' => '!%', '_' => '!_']).'%';
}
