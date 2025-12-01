<div class="col-12">
    <?php if (!empty($pro)): ?>
        <div class="row">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-md-6">
                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 500px;">
                    <?php if (!empty($pro['image'])): ?>
                        <img src="<?= BASE_ASSETS_UPLOADS ?>products/<?= htmlspecialchars($pro['image']) ?>" alt="<?= htmlspecialchars($pro['name'] ?? '') ?>" class="mw-100 mh-100">
                    <?php else: ?>
                        <p>Không có ảnh</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h2><?= htmlspecialchars($pro['name'] ?? '') ?></h2>
                <p class="text-muted"><?= htmlspecialchars($pro['description'] ?? '') ?></p>
                
                <div class="mb-3">
                    <span class="h4 text-danger fw-bold"><?= isset($pro['price']) ? number_format($pro['price']) . '₫' : '' ?></span>
                </div>

                <div class="mb-3">
                    <p><strong>Số lượng còn:</strong> <?= htmlspecialchars($pro['quantity'] ?? 0) ?></p>
                </div>

                <div class="mb-3">
                    <p><strong>Lượt xem:</strong> <?= htmlspecialchars($pro['view_count'] ?? 0) ?></p>
                </div>

                <button class="btn btn-danger btn-lg">Thêm vào giỏ hàng</button>
            </div>
        </div>
    <?php else: ?>
        <p>Không tìm thấy sản phẩm.</p>
    <?php endif; ?>
</div>