<div class="row">
    <div class="col-12">
        <hr>
    </div>

    <div class="col-mb-4">
        <div class="bg-light d-flex justify-content-center align-item-center" style="height: 300px">
            <?php if (!empty($data['image'])): ?>
                <img src="<?= BASE_ASSETS_UPLOADS . 'products/' . htmlspecialchars($data['image']) ?>"
                     alt="<?= htmlspecialchars($data['name'] ?? '') ?>"
                     class="mw-100 mh-100">
            <?php else: ?>
                <span>Không có ảnh</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-8">
        <table class="table">
            <tr>
                <th>ID</th>
                <th> <?= htmlspecialchars($data['id']) ?></th>
            </tr>
            <tr>
                <th>Tên sản phẩm</th>
                <th> <?= htmlspecialchars($data['name'] ?? '') ?></th>
            </tr>
            <tr>
                <th>Mô tả</th>
                <th> <?= htmlspecialchars($data['description'] ?? '') ?></th>
            </tr>
            <tr>
                <th>Giá</th>
                <th> <?= isset($data['price']) ? number_format($data['price']) . 'đ' : '' ?></th>
            </tr>
            <tr>
                <th>Số lượng</th>
                <th> <?= htmlspecialchars($data['quantity'] ?? 0) ?></th>
            </tr>
            <tr>
                <th>Lượt xem</th>
                <th> <?= htmlspecialchars($data['view_count'] ?? 0) ?></th>
            </tr>
            <tr>
                <th>ID Danh mục</th>
                <th> <?= htmlspecialchars($data['category_id'] ?? '') ?></th>
            </tr>
            
        </table>

        <a href="?mode=admin&action=list-product" class="btn btn-secondary">
            quay lai danh sách
        </a>
        <a href="?mode=admin&action=edit-product&id=<?= $data['id'] ?>" class="btn btn-primary">
            Sửa sản phẩm
        </a>
    </div>
</div>