
# 会话记录：网站部署与故障排查

> **日期**：2026-06-10  
> **服务器**：192.168.131.5（MariaDB 10.5.16 / PHP 8.0.27）  
> **项目**：wangzhan（数码优选）

---

## 问题一：数据库连接失败（错误码 1698）

```
数据库连接失败：SQLSTATE[HY000] [1698] Access denied for user 'root'@'localhost'
```

### 原因

`includes/db.php` 中 root 密码为空字符串 `''`，但 MariaDB 的 root 实际设置了密码。

### 解决

创建专用用户、授权并导入数据：

```sql
CREATE DATABASE IF NOT EXISTS `wangzhan`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'wangzhan'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON wangzhan.* TO 'wangzhan'@'localhost';
FLUSH PRIVILEGES;

USE wangzhan;
SOURCE /var/www/wangzhan/init.sql;
```

---

## 问题二：数据库连接失败（错误码 1044）

```
数据库连接失败：SQLSTATE[HY000] [1044] Access denied for user 'user1'@'localhost' to database 'wangzhan'
```

### 原因

`db.php` 中用的是 `user1`，但该用户仅被授予了 `wordpress` 数据库权限，无权访问 `wangzhan`。

### 解决

将 `includes/db.php` 第 10 行改为：

```php
$db_user = 'wangzhan';
$db_pass = '123456';
```

---

## 问题三：登录提示"用户名或密码错误"

### 诊断过程

| 检查项 | 命令 | 结果 |
|--------|------|------|
| 数据库数据完整性 | `SELECT CHAR_LENGTH(password_hash) FROM users` | 60 字符，格式正确 |
| PHP 版本 | `php -v` | 8.0.27（bcrypt 兼容） |
| 密码验证 | `password_verify('123456', hash)` | **false** |

### 结论

`init.sql` 中的 bcrypt 哈希内容已损坏，并非 `123456` 的有效哈希。

### 解决

在服务器上重新生成哈希并更新：

```bash
HASH=$(php -r "echo password_hash('123456', PASSWORD_BCRYPT);")
mysql -u wangzhan -p123456 wangzhan -e "UPDATE users SET password_hash = '$HASH';"
```

---

## 最终状态

| 项目 | 配置 |
|------|------|
| 数据库主机 | 127.0.0.1:3306 |
| 数据库名 | wangzhan |
| 应用用户 | wangzhan |
| 应用密码 | 123456 |
| 测试账号 | admin / 张三 / 李四 |
| 测试密码 | 123456 |
