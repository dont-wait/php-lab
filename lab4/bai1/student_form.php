<?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger" role="alert"><?= escape($error) ?></div>
<?php } ?>
<form method="post" class="p-4 border rounded shadow-sm">
    <?php if (isset($id)) { ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php } ?>
    <?php foreach (['name' => ['Họ tên', 'text', 100], 'email' => ['Email', 'email', 100], 'phone' => ['Số điện thoại', 'text', 20], 'birthday' => ['Ngày sinh', 'date', null]] as $field => [$label, $type, $length]) { ?>
        <div class="mb-3">
            <label for="<?= $field ?>" class="form-label"><?= $label ?></label>
            <input type="<?= $type ?>" id="<?= $field ?>" name="<?= $field ?>" value="<?= escape($student[$field]) ?>" class="form-control"
                <?= in_array($field, ['name', 'email'], true) ? 'required' : '' ?>
                <?= $length ? 'maxlength="'.$length.'"' : 'max="'.date('Y-m-d').'"' ?>>
        </div>
    <?php } ?>
    <button type="submit" class="btn btn-primary"><?= $submitLabel ?></button>
    <a href="list_students.php" class="btn btn-secondary">Quay lại danh sách</a>
</form>
