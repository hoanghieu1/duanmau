<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form method="post" action="<?= isset($data['id']) ? '?mode=admin&action=update-comment' : '?mode=admin&action=store-comment' ?>">
                <?php if (isset($data['id'])): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">User ID</label>
                    <input type="number" name="user_id" class="form-control" value="<?= htmlspecialchars($data['user_id'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Product ID</label>
                    <input type="number" name="product_id" class="form-control" value="<?= htmlspecialchars($data['product_id'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content" class="form-control"><?= htmlspecialchars($data['content'] ?? '') ?></textarea>
                </div>

                <button class="btn btn-primary" type="submit">Lưu</button>
                <a href="?mode=admin&action=list-comments" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
