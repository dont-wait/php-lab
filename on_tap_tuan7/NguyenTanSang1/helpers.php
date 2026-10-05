<?php
// Lab 1: escape lúc xuất HTML, không sửa dữ liệu trước khi truy vấn.
// Ref: lab1/bai10/info_process.php; lab4/bai1/student_helpers.php.
function escape($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// $_GET/$_POST có thể chứa mảng (name[]=...); chỉ nhận chuỗi.
function inputText(array $source, string $key): string
{
    return is_string($source[$key] ?? null) ? trim($source[$key]) : '';
}

function renderTable(array $rows, array $columns): void
{
    echo '<table border="1" cellpadding="8"><thead><tr>';
    foreach ($columns as $label) {
        echo '<th>'.escape($label).'</th>';
    }
    echo '</tr></thead><tbody>';
    if (!$rows) {
        echo '<tr><td colspan="'.count($columns).'">Không có dữ liệu</td></tr>';
    }
    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($columns as $key => $label) {
            echo '<td>'.escape($row[$key]).'</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
}

// Lab 3: JSON phải có Content-Type, mã HTTP lỗi để Fetch nhận biết.
// Ref: lab3/bai7/search.php; lab3/bai12/register.php.
function jsonResponse($data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}
