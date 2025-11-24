<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form method="post" action="<?= isset($data['id']) ? '?mode=admin&action=update-category' : '?mode=admin&action=store-category' ?>">
                <?php if (isset($data['id'])): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Tên</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control"><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent ID (nếu có)</label>
                    <input type="number" name="category_id" class="form-control" value="<?= htmlspecialchars($data['category_id'] ?? '') ?>">
                </div>

                <button class="btn btn-primary" type="submit">Lưu</button>
                <a href="?mode=admin&action=list-categories" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
