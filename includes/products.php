<?php
/**
 * 商品数据 — 硬编码产品列表
 * 供 index.php 和 detail.php 共用
 */

$products = [
    1 => [
        'id'          => 1,
        'name'        => '智能手机 X1 Pro',
        'price'       => 2999,
        'image'       => 'https://placehold.co/600x400/667eea/ffffff?text=X1+Pro',
        'description' => '旗舰性能，极致影像。搭载最新骁龙处理器，5000 万像素 AI 三摄，120Hz 高刷屏，让你爱不释手。',
        'specs'       => [
            '屏幕'   => '6.7 英寸 AMOLED 曲面屏, 120Hz',
            '处理器' => '骁龙 8 Gen 3',
            '内存'   => '12GB LPDDR5X',
            '存储'   => '256GB UFS 4.0',
            '电池'   => '5000mAh，支持 100W 快充',
            '相机'   => '后置 50MP+12MP+8MP，前置 32MP',
            '系统'   => 'Android 14',
            '重量'   => '198g',
        ],
    ],
    2 => [
        'id'          => 2,
        'name'        => '无线降噪耳机 AirBuds Pro',
        'price'       => 399,
        'image'       => 'https://placehold.co/600x400/764ba2/ffffff?text=AirBuds+Pro',
        'description' => '沉浸式主动降噪，空间音频体验。超长续航 30 小时，IPX5 防水，通勤运动两相宜。',
        'specs'       => [
            '降噪'   => '自适应主动降噪 (ANC)',
            '续航'   => '单次 8 小时，总续航 30 小时',
            '连接'   => '蓝牙 5.3',
            '防水'   => 'IPX5 级防水',
            '充电'   => 'Type-C / 无线充电',
            '重量'   => '单耳 5.2g',
        ],
    ],
    3 => [
        'id'          => 3,
        'name'        => '智能手表 Watch S3',
        'price'       => 1299,
        'image'       => 'https://placehold.co/600x400/2c3e50/ffffff?text=Watch+S3',
        'description' => '健康管理专家，时尚腕上伴侣。全天候心率血氧监测，GPS 精准定位，14 天超长续航。',
        'specs'       => [
            '屏幕'   => '1.5 英寸 LTPO AMOLED',
            '传感器' => '心率、血氧、加速度计、陀螺仪',
            '定位'   => '双频 GPS + GLONASS',
            '续航'   => '典型模式 14 天',
            '防水'   => '5ATM 游泳级防水',
            '重量'   => '52g (含表带)',
        ],
    ],
    4 => [
        'id'          => 4,
        'name'        => '便携快充移动电源 20000mAh',
        'price'       => 149,
        'image'       => 'https://placehold.co/600x400/27ae60/ffffff?text=PowerBank',
        'description' => '大容量，小身材。20000mAh 足量电芯，65W 双向快充，可同时充三台设备。',
        'specs'       => [
            '容量'   => '20000mAh (74Wh)',
            '输出'   => 'USB-C 65W + USB-A x2',
            '输入'   => 'USB-C 65W',
            '快充'   => '支持 PD 3.0 / QC 4+',
            '数显'   => 'LED 电量百分比显示',
            '重量'   => '385g',
        ],
    ],
    5 => [
        'id'          => 5,
        'name'        => '机械键盘 RGB 幻彩版',
        'price'       => 599,
        'image'       => 'https://placehold.co/600x400/e74c3c/ffffff?text=Keyboard',
        'description' => 'Cherry MX 原厂轴体，全键热插拔。三模连接，1680 万色 RGB 背光，PBT 键帽不油腻。',
        'specs'       => [
            '轴体'   => 'Cherry MX 红轴',
            '连接'   => '有线 / 2.4G / 蓝牙 5.0',
            '布局'   => '87 键 TKL 紧凑布局',
            '背光'   => '1680 万色 RGB',
            '键帽'   => 'PBT 双色注塑',
            '重量'   => '910g',
        ],
    ],
    6 => [
        'id'          => 6,
        'name'        => '27 英寸 4K 专业显示器',
        'price'       => 1899,
        'image'       => 'https://placehold.co/600x400/8e44ad/ffffff?text=4K+Monitor',
        'description' => '专业色彩，创作利器。27 寸 IPS 面板，4K UHD 分辨率，Type-C 一线连，HDR400 认证。',
        'specs'       => [
            '面板'   => '27 英寸 IPS',
            '分辨率' => '3840 × 2160 (4K UHD)',
            '色域'   => '95% DCI-P3 / 100% sRGB',
            '接口'   => 'Type-C 65W + HDMI 2.1 + DP 1.4',
            'HDR'    => 'VESA DisplayHDR 400',
            '支架'   => '升降旋转可调',
        ],
    ],
];

/**
 * 根据 ID 获取单个商品，不存在返回 null
 */
function getProductById(int $id): ?array
{
    global $products;
    return $products[$id] ?? null;
}
