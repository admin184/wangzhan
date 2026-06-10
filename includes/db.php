<?php
/**
 * 数据库连接配置
 * MariaDB
 */

$db_host = '127.0.0.1';
$db_port = 3306;
$db_name = 'wangzhan';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO(
        "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die('数据库连接失败：' . $e->getMessage());
}
