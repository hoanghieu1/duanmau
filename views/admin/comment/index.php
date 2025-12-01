<table class="table">
    <thead>
        <tr>
            <th>id</th>
            <th>user_id</th>
            <th>product_id</th>
            <th>content</th>
            <th>created_at</th>
            <th>status</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $cmt): ?>
            <tr>
                <td><?= $cmt['id'] ?></td>
                <td><?= $cmt['user_id'] ?></td>
                <td><?= $cmt['product_id'] ?></td>
                <td><?= htmlspecialchars($cmt['content']) ?></td>
                <td><?= $cmt['created_at'] ?></td>
                <td><?= $cmt['status'] == 1 ? 'Hiển thị' : 'Đã ẩn' ?></td>
                <td>
                    <?php if ($cmt['status'] == 1): ?>
                        <!-- nút Ẩn -->
                        <a href="?mode=admin&action=hide-comment&id=<?= $cmt['id'] ?>"
                           class="btn btn-warning btn-sm">
                            Ẩn
                        </a>
                    <?php else: ?>
                        <!-- nút Hiện -->
                        <a href="?mode=admin&action=show-comment&id=<?= $cmt['id'] ?>"
                           class="btn btn-success btn-sm">
                            Hiện
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
