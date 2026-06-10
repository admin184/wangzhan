-- ============================================
-- 网站数据库初始化脚本
-- 适用于 MariaDB
-- ============================================

CREATE DATABASE IF NOT EXISTS `wangzhan`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `wangzhan`;

-- -------------------------------------------
-- 用户表
-- -------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------
-- 评论表
-- -------------------------------------------
CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `content` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------
-- 预置测试数据
-- -------------------------------------------

-- 测试用户（密码均为 123456 的 bcrypt 哈希）
INSERT INTO `users` (`username`, `password_hash`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('张三', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('李四', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- 测试评论
INSERT INTO `comments` (`product_id`, `username`, `content`) VALUES
(1, '张三', '这款手机用了一周，电池续航很给力，系统也很流畅，推荐！'),
(1, '李四', '拍照效果不错，就是价格稍微贵了点。'),
(2, 'admin', '音质真的惊艳到我了，降噪效果也很好，通勤必备。'),
(3, '张三', '手表颜值很高，功能也很丰富，睡眠监测挺准的。');
