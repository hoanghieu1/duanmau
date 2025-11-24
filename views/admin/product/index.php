<div class="col-12">
    <div class="mb-3">
        <a href="?mode=admin&action=create-product" class="btn btn-success">
            + Thêm sản phẩm
        </a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $pro): ?>
            <tr>
                <td><?= $pro['id'] ?></td>

                <td>
                    <img
                        src="<?= BASE_ASSETS_UPLOADS . 'products/' . $pro['image'] ?>"
                        alt="<?= htmlspecialchars($pro['name']) ?>"
                        width="80"
                        height="80"
                        onerror="this.onerror=null; this.src='<?= BASE_ASSETS_UPLOADS ?>no-image.png';"
                    >
                </td>

                <td><?= $pro['name'] ?></td>

                <!-- nếu bạn đang truyền category_id thì tạm thời hiển thị id -->
                <td><?= $pro['category_id'] ?></td>

                <td><?= substr($pro['description'], 0, 50) . '...' ?></td>

                <td><?= number_format($pro['price'], 0, ',', '.') ?> đ</td>

                <td><?= $pro['quantity'] ?></td>

                <td>
                    <a href="?mode=admin&action=show-product&id=<?= $pro['id'] ?>"
                       class="btn btn-primary btn-sm">Xem</a>

                    <a href="?mode=admin&action=edit-product&id=<?= $pro['id'] ?>"
                       class="btn btn-warning btn-sm">Sửa</a>

                    <a href="?mode=admin&action=delete-product&id=<?= $pro['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
