<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form method="post" action="<?= isset($data['id']) ? '?mode=admin&action=update-user' : '?mode=admin&action=store-user' ?>">
                <?php if (isset($data['id'])): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu <?= isset($data['id']) ? '(để trống nếu không đổi)' : '' ?></label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button class="btn btn-primary" type="submit">Lưu</button>
                <a href="?mode=admin&action=list-users" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
