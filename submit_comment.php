<?php
/**
 * 评论提交处理
 */
require_once __DIR__ . '/includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 未登录拦截
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// 仅接受 POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$content    = trim($_POST['content'] ?? '');
$username   = $_SESSION['user']['username'];

// 参数校验
if ($product_id <= 0 || $content === '') {
    header('Location: detail.php?id=' . $product_id . '&error=empty');
    exit;
}

// 写入数据库
$redirect = 'detail.php?id=' . $product_id;
try {
    $stmt = $pdo->prepare('INSERT INTO comments (product_id, username, content) VALUES (:pid, :uname, :content)');
    $stmt->execute([
        ':pid'     => $product_id,
        ':uname'   => $username,
        ':content' => $content,
    ]);
    $redirect .= '&commented=1';
} catch (PDOException $e) {
    $redirect .= '&error=db';
}

header('Location: ' . $redirect);
exit;
