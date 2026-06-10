<?php
/**
 * 公共头部 — 导航栏 + Session 逻辑
 * 所有页面通过 include 引入
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>数码优选 — 品质数码生活</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- 自定义样式 -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- ==================== 顶部导航栏 ==================== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-shop me-2"></i>数码优选
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="切换导航">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['SCRIPT_NAME']) === 'index.php' ? 'active' : '' ?>"
                       href="index.php">首页</a>
                </li>
            </ul>

            <!-- 右侧：登录 / 用户信息 -->
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- 已登录 -->
                    <span class="text-light me-3">
                        <i class="bi bi-person-circle me-1"></i>欢迎您，<?= htmlspecialchars($_SESSION['user']['username']) ?>
                    </span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>退出
                    </a>
                <?php else: ?>
                    <!-- 未登录 -->
                    <a href="login.php" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i>登录
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- ==================== 主内容区域开始 ==================== -->
<main class="container my-4">
