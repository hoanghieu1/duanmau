<div class="col-12">
    <div class="mb-3">
        <a href="?mode=admin&action=create-category" class="btn btn-success">+ Thêm danh mục</a>
    </div>

    <?php if (!empty($_GET['error'])): ?>
        <?php if ($_GET['error'] === 'has_products'): ?>
            <div class="alert alert-danger">Không thể xóa danh mục này vì đang có sản phẩm thuộc danh mục. Vui lòng xóa hoặc chuyển danh mục sản phẩm trước.</div>
        <?php elseif ($_GET['error'] === 'has_children'): ?>
            <div class="alert alert-danger">Không thể xóa danh mục cha vì còn danh mục con tham chiếu tới nó. Vui lòng xóa hoặc chuyển danh mục con trước.</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (empty($data)): ?>
        <p>Không có danh mục nào.</p>
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
                        <a href="?mode=admin&action=edit-category&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="?mode=admin&action=delete-category&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
