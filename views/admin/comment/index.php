<div class="col-12">
    <div class="mb-3">
        <a href="?mode=admin&action=create-comment" class="btn btn-success">+ Thêm bình luận</a>
    </div>

    <?php if (empty($data)): ?>
        <p>Không có bình luận.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <?php foreach (array_keys($data[0]) as $col): ?>
                        <th><?= htmlspecialchars($col) ?></th>
                    <?php endforeach; ?>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    <?php foreach ($row as $val): ?>
                        <td><?= htmlspecialchars($val) ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="?mode=admin&action=edit-comment&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="?mode=admin&action=delete-comment&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
