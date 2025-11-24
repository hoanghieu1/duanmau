<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form method="post" action="<?= isset($data['id']) ? '?mode=admin&action=update-product' : '?mode=admin&action=store-product' ?>" enctype="multipart/form-data">
                <?php if (isset($data['id'])): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-control">
                        <option value="">-- Chọn --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($data['category_id']) && $data['category_id'] == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control"><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($data['price'] ?? 0) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($data['quantity'] ?? 0) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ảnh</label>
                        <input type="file" name="image" class="form-control">
                        <?php if (!empty($data['image'])): ?>
                            <div class="mt-2">
                                <img src="<?= BASE_ASSETS_UPLOADS . $data['image'] ?>" alt="<?= htmlspecialchars($data['name'] ?? '') ?>" width="120">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Lưu</button>
                <a href="?mode=admin&action=list-product" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
