<?php
/**
 * 首页 — 商品列表
 */
require_once __DIR__ . '/includes/products.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- 页面标题 -->
<div class="text-center mb-5">
    <h1 class="fw-bold">探索数码好物</h1>
    <p class="text-muted">精选品质数码产品，为你的生活添彩</p>
</div>

<!-- 商品卡片网格 -->
<div class="row g-4">
    <?php foreach ($products as $product): ?>
        <div class="col-sm-6 col-lg-4">
            <div class="card product-card h-100">
                <img src="<?= htmlspecialchars($product['image']) ?>"
                     class="card-img-top"
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     loading="lazy">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="card-text text-muted flex-grow-1">
                        <?= htmlspecialchars($product['description']) ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="price">¥<?= number_format($product['price']) ?></span>
                        <a href="detail.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">
                            查看详情 <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
