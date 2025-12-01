<?php
// $categories, $products, $selectedCategoryId đã được controller truyền sang
?>

<!-- Bộ lọc danh mục -->
<form class="row mb-4" method="GET">
    <input type="hidden" name="action" value="products">

    <div class="col-md-4">
        <label class="form-label">Lọc theo danh mục</label>
        <select name="category_id" class="form-select" onchange="this.form.submit()">
            <option value="">-- Tất cả danh mục --</option>
            <?php foreach ($categories as $cate): ?>
                <option value="<?= $cate['id'] ?>"
                    <?= (isset($selectedCategoryId) && $selectedCategoryId == $cate['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cate['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

<!-- Danh sách sản phẩm -->
<div class="row">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $pro): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="bg-light d-flex justify-content-center align-items-center" style="height: 250px;">
                        <?php if (!empty($pro['image'])): ?>
                            <img src="<?= BASE_ASSETS_UPLOADS ?>products/<?= htmlspecialchars($pro['image']) ?>"
                                 alt="<?= htmlspecialchars($pro['name'] ?? '') ?>"
                                 class="mw-100 mh-100">
                        <?php else: ?>
                            <span>Không có ảnh</span>
                        <?php endif; ?>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <a href="<?= BASE_URL . '?action=detail-product&id=' . $pro['id'] ?>">
                                <?= htmlspecialchars($pro['name'] ?? '') ?>
                            </a>
                        </h5>

                        <p class="card-text text-danger fw-bold mb-2">
                            <?= isset($pro['price']) ? number_format($pro['price']) . '₫' : '' ?>
                        </p>

                        <a href="<?= BASE_URL . '?action=detail-product&id=' . $pro['id'] ?>"
                           class="btn btn-primary mt-auto">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Không có sản phẩm trong danh mục này.</p>
    <?php endif; ?>
</div>
