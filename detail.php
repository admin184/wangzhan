<?php
/**
 * 商品详情与评论页
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/products.php';
require_once __DIR__ . '/includes/header.php';

// ---------- 获取商品 ----------
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = getProductById($id);

if (!$product): ?>
    <div class="alert alert-danger text-center">
        <h4><i class="bi bi-exclamation-triangle me-2"></i>商品不存在</h4>
        <p>抱歉，找不到该商品。请返回 <a href="index.php">首页</a> 浏览其他商品。</p>
    </div>
<?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
endif;

// ---------- 获取评论 ----------
try {
    $stmt = $pdo->prepare('SELECT username, content, created_at FROM comments WHERE product_id = :pid ORDER BY created_at DESC');
    $stmt->execute([':pid' => $id]);
    $comments = $stmt->fetchAll();
} catch (PDOException $e) {
    $comments = [];
    $dbError = true;
}
?>

<!-- ==================== 商品详情 ==================== -->
<div class="row mb-5">
    <!-- 商品图片 -->
    <div class="col-md-6 mb-4 mb-md-0">
        <img src="<?= htmlspecialchars($product['image']) ?>"
             class="detail-image"
             alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <!-- 商品信息 -->
    <div class="col-md-6">
        <h2 class="fw-bold mb-2"><?= htmlspecialchars($product['name']) ?></h2>
        <p class="text-muted mb-3"><?= htmlspecialchars($product['description']) ?></p>
        <h3 class="price mb-4">¥<?= number_format($product['price']) ?></h3>

        <!-- 规格参数 -->
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">
                <i class="bi bi-list-ul me-2"></i>规格参数
            </div>
            <div class="card-body p-0">
                <table class="table table-striped specs-table mb-0">
                    <tbody>
                        <?php foreach ($product['specs'] as $label => $value): ?>
                            <tr>
                                <th><?= htmlspecialchars($label) ?></th>
                                <td><?= htmlspecialchars($value) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 返回按钮 -->
        <a href="index.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>返回首页
        </a>
    </div>
</div>

<!-- ==================== 评论区 ==================== -->
<div class="card">
    <div class="card-header bg-light fw-bold">
        <i class="bi bi-chat-dots me-2"></i>用户评论
        <span class="badge bg-secondary ms-2"><?= count($comments) ?></span>
    </div>
    <div class="card-body">

        <!-- 评论列表 -->
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $c): ?>
                <div class="comment-item">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="comment-username">
                            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($c['username']) ?>
                        </span>
                        <span class="comment-time"><?= htmlspecialchars($c['created_at']) ?></span>
                    </div>
                    <p class="mb-0 text-muted"><?= nl2br(htmlspecialchars($c['content'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php elseif (isset($dbError)): ?>
            <div class="alert alert-warning mb-0">评论数据暂时无法加载，请稍后再试。</div>
        <?php else: ?>
            <p class="text-muted mb-0 text-center">暂无评论，成为第一个评论的人吧！</p>
        <?php endif; ?>

        <!-- 发表评论：条件渲染 -->
        <hr>
        <?php if (!isset($_SESSION['user'])): ?>
            <!-- 未登录：显示引导提示 -->
            <div class="alert alert-warning mb-0 text-center">
                <i class="bi bi-info-circle me-1"></i>
                想要参与讨论？请先
                <a href="login.php" class="alert-link">点击登录</a>。
            </div>
        <?php else: ?>
            <!-- 已登录：显示评论表单 -->
            <form action="submit_comment.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <div class="mb-3">
                    <label for="commentContent" class="form-label fw-bold">
                        <i class="bi bi-pencil-square me-1"></i>发表你的评论
                    </label>
                    <textarea class="form-control"
                              id="commentContent"
                              name="content"
                              rows="3"
                              placeholder="写下你对这件商品的看法……"
                              required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>提交评论
                </button>
            </form>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
