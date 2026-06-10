<?php
/**
 * 退出登录
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 清除 Session
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}
session_destroy();

// 重定向回首页
header('Location: index.php');
exit;
