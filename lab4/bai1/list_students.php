<?php

require __DIR__.'/connect.php';
require __DIR__.'/student_helpers.php';

$keyword = is_string($_GET['keyword'] ?? null) ? trim($_GET['keyword']) : '';
$sort = is_string($_GET['sort'] ?? null) ? $_GET['sort'] : 'id';
$sort = in_array($sort, ['id', 'name', 'email'], true) ? $sort : 'id';
$direction = ($_GET['direction'] ?? ($sort === 'id' ? 'desc' : 'asc')) === 'desc' ? 'desc' : 'asc';
$limit = 5;
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 1;

$stmtCount = $conn->prepare('SELECT COUNT(*) FROM students WHERE name LIKE :keyword');
$stmtCount->execute([':keyword' => "%$keyword%"]);
$totalRecords = (int) $stmtCount->fetchColumn();
$totalPages = max(1, (int) ceil($totalRecords / $limit));
$page = min($page, $totalPages);
$offset = ($page - 1) * $limit;

// Tên cột và chiều sắp xếp chỉ lấy từ danh sách cho phép ở trên.
$stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE :keyword
    ORDER BY $sort $direction, id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pageUrl = fn ($number) => '?'.http_build_query(['keyword' => $keyword, 'sort' => $sort, 'direction' => $direction, 'page' => $number]);

require __DIR__.'/header.php';
?>
<h1 class="h3 mb-3">Danh sách sinh viên</h1>
<form method="get" class="row g-2 align-items-end mb-3">
    <div class="col-md-4">
        <label for="keyword" class="form-label">Tìm theo tên</label>
        <input id="keyword" name="keyword" value="<?= escape($keyword) ?>" class="form-control" placeholder="Nhập tên sinh viên">
    </div>
    <div class="col-md-2">
        <label for="sort" class="form-label">Sắp xếp theo</label>
        <select id="sort" name="sort" class="form-select">
            <?php foreach (['id' => 'ID', 'name' => 'Họ tên', 'email' => 'Email'] as $value => $label) { ?>
                <option value="<?= $value ?>" <?= $sort === $value ? 'selected' : '' ?>><?= $label ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-2">
        <label for="direction" class="form-label">Thứ tự</label>
        <select id="direction" name="direction" class="form-select">
            <option value="asc" <?= $direction === 'asc' ? 'selected' : '' ?>>Tăng dần</option>
            <option value="desc" <?= $direction === 'desc' ? 'selected' : '' ?>>Giảm dần</option>
        </select>
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary" type="submit">Tìm kiếm / Sắp xếp</button>
        <a href="list_students.php" class="btn btn-outline-secondary">Đặt lại</a>
    </div>
</form>
<p class="text-secondary">Tổng: <?= $totalRecords ?> sinh viên · Trang <?= $page ?>/<?= $totalPages ?></p>
<div class="table-responsive">
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr><th>ID</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Ngày sinh</th><th>Thao tác</th></tr>
    </thead>
    <tbody>
        <?php if (! $students) { ?>
            <tr><td colspan="6" class="text-center">Không có dữ liệu</td></tr>
        <?php } ?>
        <?php foreach ($students as $row) { ?>
            <tr>
                <td><?= escape($row['id']) ?></td>
                <td><?= escape($row['name']) ?></td>
                <td><?= escape($row['email']) ?></td>
                <td><?= escape($row['phone']) ?></td>
                <td><?= escape($row['birthday'] ?? '') ?></td>
                <td class="text-nowrap">
                    <a href="edit_student.php?id=<?= (int) $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="delete_student.php?id=<?= (int) $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<a href="add_student.php" class="btn btn-primary mb-3">Thêm sinh viên</a>
<?php if ($totalRecords > 0) { ?>
<nav aria-label="Phân trang sinh viên">
    <ul class="pagination flex-wrap">
        <?php if ($page > 1) { ?>
            <li class="page-item"><a class="page-link" href="<?= escape($pageUrl(1)) ?>">Đầu</a></li>
            <li class="page-item"><a class="page-link" href="<?= escape($pageUrl($page - 1)) ?>">Trước</a></li>
        <?php } ?>
        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) { ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>"><a class="page-link" <?= $i === $page ? 'aria-current="page"' : '' ?> href="<?= escape($pageUrl($i)) ?>"><?= $i ?></a></li>
        <?php } ?>
        <?php if ($page < $totalPages) { ?>
            <li class="page-item"><a class="page-link" href="<?= escape($pageUrl($page + 1)) ?>">Sau</a></li>
            <li class="page-item"><a class="page-link" href="<?= escape($pageUrl($totalPages)) ?>">Cuối</a></li>
        <?php } ?>
    </ul>
</nav>
<?php } ?>
<?php require __DIR__.'/footer.php'; ?>
