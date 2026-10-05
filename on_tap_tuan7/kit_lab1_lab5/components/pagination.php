<?php
namespace LabKit;
// Lab 4 list_students.php. COUNT và SELECT phải dùng cùng điều kiện lọc.
function pagination(int $total, int $page, int $perPage = 5): array
{
    if ($total < 0 || $perPage < 1) throw new \InvalidArgumentException('Tổng không âm, perPage phải dương.');
    $pages = max(1, (int) ceil($total / $perPage));
    $page = min(max(1, $page), $pages);
    return ['total' => $total, 'page' => $page, 'pages' => $pages,
            'limit' => $perPage, 'offset' => ($page - 1) * $perPage];
}
function paginationLinks(array $paging, array $filters = []): void
{
    echo '<nav aria-label="Phân trang">';
    for ($i = max(1, $paging['page'] - 2); $i <= min($paging['pages'], $paging['page'] + 2); $i++) {
        $url = '?'.http_build_query(array_merge($filters, ['page' => $i]));
        echo '<a href="'.escape($url).'"'.($i === $paging['page'] ? ' aria-current="page"' : '').'>'.$i.'</a> ';
    }
    echo '</nav>';
}
