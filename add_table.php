<?php

declare(strict_types=1);

$db = new PDO('sqlite:' . __DIR__ . '/database/app.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $db->exec("CREATE TABLE IF NOT EXISTS ranks (
//   id INTEGER PRIMARY KEY AUTOINCREMENT,
//   [type] TEXT NOT NULL
// )");

// $db->exec("INSERT INTO ranks ([type]) 
// VALUES 
// ('Sắt'),
// ('Đồng'),
// ('Bạc'),
// ('Vàng'),
// ('Bạch Kim'),
// ('Kim Cương'),
// ('Siêu Việt'),
// ('Bất Tử'),
// ('Tỏa sáng')");

// $db->exec("CREATE TABLE IF NOT EXISTS `status` (
//   id INTEGER PRIMARY KEY AUTOINCREMENT,
//   [type] TEXT NOT NULL
// )");

// $db->exec("INSERT INTO `status` ([type]) 
// VALUES 
// ('Rảnh'),
// ('Bận')");

$db->exec("CREATE TABLE IF NOT EXISTS sale_accounts (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  [status] TEXT NOT NULL,
  price INTEGER NOT NULL,
  gmail TEXT NOT NULL,
  letter TEXT NOT NULL CHECK(letter IN ('Back', 'Có')),
  commitment TEXT NOT NULL,
  [description] TEXT NOT NULL,
  avatar TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$accounts = [
  ['Rảnh', 100855, 'test@gmail.com', 'Back', 'Cam kết 100% acc chính chủ, không bị hack, không bị ban, có thể chỉnh sửa thông tin đăng nhập sau khi mua', 'Tên Acc: Player#002, Acc có tham gia sự kiện mừng sinh nhật game thứ 15', 'default-sale-account-avatar.png'],
  ['Rảnh', 900855, 'test@gmail.com', 'Back', 'Cam kết 100% acc chính chủ, không bị hack, không bị ban, có thể chỉnh sửa thông tin đăng nhập sau khi mua', 'Tên Acc: Singer#002, Acc có tham gia sự kiện mừng sinh nhật game thứ 15', 'default-sale-account-avatar.png'],
  ['Bận', 111111, 'test@gmail.com', 'Có', 'Cam kết 100% acc chính chủ, không bị hack, không bị ban, có thể chỉnh sửa thông tin đăng nhập sau khi mua', 'Tên Acc: HERO#003, Acc có tham gia sự kiện mừng sinh nhật game thứ 15', 'default-sale-account-avatar.png'],
  ['Bận', 100000, 'test@gmail.com', 'Có', 'Cam kết 100% acc chính chủ, không bị hack, không bị ban, có thể chỉnh sửa thông tin đăng nhập sau khi mua', 'Tên Acc: GUARDIAN#004, Acc có tham gia sự kiện mừng sinh nhật game thứ 15', 'default-sale-account-avatar.png'],
];

$stmt = $db->prepare("INSERT INTO sale_accounts ([status], price, gmail, letter, commitment, [description], avatar) VALUES (?, ?, ?, ?, ?, ?, ?)");
foreach ($accounts as $acc) {
  $stmt->execute($acc);
}
