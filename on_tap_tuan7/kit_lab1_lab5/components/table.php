<?php
namespace LabKit;
// Lab 1 bài 18; Lab 4/5 xuất bảng, escape từng ô.
function table(array $rows, array $columns): void
{
    if (!$columns) throw new \InvalidArgumentException('Bảng phải có cột.');
    echo '<table border="1" cellpadding="8"><thead><tr>';
    foreach ($columns as $label) echo '<th>'.escape($label).'</th>';
    echo '</tr></thead><tbody>';
    if (!$rows) echo '<tr><td colspan="'.count($columns).'">Không có dữ liệu</td></tr>';
    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($columns as $key => $label) echo '<td>'.escape($row[$key] ?? '').'</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}
