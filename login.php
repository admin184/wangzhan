<?php
/**
 * 登录页 — 居中卡片表单
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

// 已登录用户直接跳转首页
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = '请输入用户名和密码。';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = :uname LIMIT 1');
            $stmt->execute([':uname' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // 登录成功 — 写入 Session
                $_SESSION['user'] = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                ];
                header('Location: index.php');
                exit;
            } else {
                $error = '用户名或密码错误，请重试。';
            }
        } catch (PDOException $e) {
            $error = '登录服务暂时不可用，请稍后再试。';
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card login-card">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-person-circle display-4 text-primary"></i>
                    <h3 class="mt-2 fw-bold">用户登录</h3>
                    <p class="text-muted small">登录后可发表评论参与讨论</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="关闭"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">用户名</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   placeholder="请输入用户名"
                                   value="<?= htmlspecialchars($username ?? '') ?>"
                                   required
                                   autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">密码</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="请输入密码"
                                   required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>登录
                    </button>
                </form>
              
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
