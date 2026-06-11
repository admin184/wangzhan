# 数码优选 — 数码产品展示与评论网站

一个基于原生 PHP + MariaDB 的数码产品展示与评论网站。支持商品浏览、用户登录、评论发表等核心功能。

## 技术栈

| 层面 | 技术 |
|------|------|
| 后端 | PHP 8.0+（无框架） |
| 数据库 | MariaDB 10.5+ |
| 前端 | Bootstrap 5.3.3 + Bootstrap Icons 1.11.3（CDN） |
| Web 服务器 | Apache（httpd） |
| 操作系统 | Rocky Linux 9.2 |

## 功能概览

- **商品展示** — 首页 6 款数码产品卡片网格，响应式布局
- **商品详情** — 大图展示 + 规格参数表 + 评论区
- **用户登录** — bcrypt 密码验证，Session 会话管理
- **评论系统** — 已登录用户发表评论，游客可查看但不可发表
- **权限控制** — 基于 Session 的状态感知，导航栏 / 评论表单条件渲染

## 目录结构

```
wangzhan/
├── index.php                  # 首页 — 商品卡片网格
├── detail.php                 # 商品详情页 + 评论区
├── login.php                  # 登录页 — 居中卡片表单
├── logout.php                 # 退出登录
├── submit_comment.php         # 评论提交（仅 POST，需登录）
├── init.sql                   # 数据库初始化脚本（含测试数据）
├── includes/
│   ├── db.php                 # PDO 数据库连接
│   ├── header.php             # 公共头部 + Session + Bootstrap CDN
│   ├── footer.php             # 公共页脚
│   └── products.php           # 商品数据（6 款硬编码）
├── assets/
│   └── css/
│       └── style.css          # 自定义样式
└── docs/
    └── 产品需求文档.md
```

## 快速开始（本地开发）

1. 确保 PHP 8.0+ 和 MariaDB 已安装并运行。

2. 初始化数据库：

```bash
mysql -u root < init.sql
```

3. 修改数据库连接配置（按需）：

编辑 `includes/db.php`，调整主机、端口、用户名和密码。

4. 启动 PHP 内置服务器：

```bash
php -S localhost:8000
```

5. 浏览器访问 `http://localhost:8000`

> PHP 内置服务器仅用于本地开发，不可用于生产环境。

## 生产环境部署（Rocky Linux + Apache）

### 环境准备

```bash
# 启用 EPEL 与 Remi 仓库
dnf install -y epel-release
dnf install -y https://rpms.remirepo.net/enterprise/remi-release-9.rpm

# 安装 Apache + PHP 8.2 + MariaDB
dnf module enable -y php:remi-8.2
dnf install -y httpd php php-mysqlnd php-cli mariadb-server

# 启动服务并设为开机自启
systemctl enable --now httpd mariadb

# 开放防火墙
firewall-cmd --permanent --add-service=http
firewall-cmd --reload
```

### 部署步骤

```bash
# 1. 复制代码到 Apache 文档根目录
cp -r * /var/www/html/

# 2. 调整 SELinux 上下文
restorecon -Rv /var/www/html

# 3. 初始化数据库
mysql_secure_installation
mysql -u root -p < /var/www/html/init.sql

# 4. 按需修改数据库连接配置
vi /var/www/html/includes/db.php
```

浏览器访问虚拟机 IP 验证部署。

## 数据库

| 表名 | 说明 | 关键字段 |
|------|------|---------|
| `users` | 用户表 | `id`, `username`（唯一）, `password_hash`（bcrypt） |
| `comments` | 评论表 | `id`, `product_id`, `username`, `content`, `created_at` |

数据库名：`wangzhan`，字符集：`utf8mb4`。

## 测试账号

| 用户名 | 密码 |
|--------|------|
| admin | 123456 |
| 张三 | 123456 |
| 李四 | 123456 |

## 商品列表

| ID | 商品 | 价格 |
|----|------|------|
| 1 | 智能手机 X1 Pro | ¥2,999 |
| 2 | 无线降噪耳机 AirBuds Pro | ¥399 |
| 3 | 智能手表 Watch S3 | ¥1,299 |
| 4 | 便携快充移动电源 20000mAh | ¥149 |
| 5 | 机械键盘 RGB 幻彩版 | ¥599 |
| 6 | 27 英寸 4K 专业显示器 | ¥1,899 |

## 页面流转

```
首页 (index.php) ──点击卡片──▶ 详情页 (detail.php)
     ▲                              │
     │◄──── 返回首页 ◄──────────────┘
     │
登录页 (login.php) ──登录成功──▶ 首页
退出 (logout.php) ──销毁 Session──▶ 首页
```

## 权限模型

- **未登录（游客）**：浏览商品和评论，评论输入框隐藏，显示登录引导
- **已登录**：导航栏显示用户名和退出按钮，可发表评论

## 样式说明

- 全局背景 `#f5f6fa`，深色导航栏，深蓝灰页脚
- 商品卡片：12px 圆角，hover 上浮 + 阴影效果
- 价格：红色 `#e74c3c`
- 卡片图片：固定高度 220px，`object-fit: cover`
- 自定义样式位于 `assets/css/style.css`，修改后刷新即可生效

## 许可证

仅用于学习与演示。
