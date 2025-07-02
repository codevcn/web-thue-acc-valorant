<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/database/app.sqlite';
$db = new PDO('sqlite:' . $dbPath);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("
CREATE UNIQUE INDEX index_game_code ON game_accounts(game_code);
");

// // Tạo bảng users như cũ
// $db->exec("CREATE TABLE IF NOT EXISTS users (
//   id INTEGER PRIMARY KEY AUTOINCREMENT,
//   username TEXT UNIQUE NOT NULL,
//   [password] TEXT NOT NULL,
//   full_name TEXT NOT NULL,
//   phone TEXT NOT NULL,
//   [role] TEXT NOT NULL CHECK(role IN ('ADMIN')),
//   fb_link TEXT,
//   zalo_link TEXT,
//   created_at DATETIME DEFAULT CURRENT_TIMESTAMP
// )");

// // Nếu bảng game_accounts đã tồn tại → xử lý đổi tên, sao chép, và xóa
// $db->exec("DROP TABLE IF EXISTS game_accounts_old");
// $db->exec("ALTER TABLE game_accounts RENAME TO game_accounts_old");

// // Tạo lại bảng game_accounts với cấu trúc mới
// $db->exec("CREATE TABLE game_accounts (
//   id INTEGER PRIMARY KEY AUTOINCREMENT,
//   acc_name TEXT NOT NULL,
//   rank TEXT NOT NULL,
//   game_code TEXT NOT NULL,
//   status TEXT NOT NULL DEFAULT 'Rảnh',
//   description TEXT,
//   device_type TEXT,
//   created_at DATETIME DEFAULT CURRENT_TIMESTAMP
// )");

// // Copy dữ liệu cũ từ game_accounts_old → game_accounts
// $db->exec("
//   INSERT INTO game_accounts (id, acc_name, rank, game_code, status, description, device_type, created_at)
//   SELECT id, acc_name, rank, game_code, status, description, device_type, created_at
//   FROM game_accounts_old
// ");

// // Xóa bảng tạm
// $db->exec("DROP TABLE game_accounts_old");

// // Dữ liệu mẫu cho game_accounts
// $accounts = [
//   ['00Valorantime#00Pro', 'gold 1', 'Mã 000', 'Bận', '', 'Máy nhà'],
//   ['02Valorantime#02Pro', 'gold 3', 'Mã 002', 'Bận', '', 'Máy nhà'],
//   ['SC ZZZ#8002', 'gold 3', 'Mã 003', 'Rảnh', '', 'Máy nhà'],
//   ['04Valorantime#04Pro', 'plat 1', 'Mã 004', 'Bận', '', 'Máy net'],
//   ['Công An Hà Nội#8386', 'gold 3', 'Mã 006', 'Bận', '', 'Máy nhà'],
//   ['07Valorantime#07Pro', 'sil 1', 'Mã 007', 'Rảnh', '', 'Máy nhà'],
//   ['08Valorantime#08Pro', 'plat 2', 'Mã 008', 'Bận', '', 'Máy nhà'],
//   ['09Valorantime#09Pro', 'plat 1', 'Mã 009', 'Rảnh', '', 'Máy nhà'],
//   ['10Valorantime#10Pro', 'plat 2', 'Mã 010', 'Bận', '', 'Máy nhà'],
//   ['11Valorantime#11Pro', 'plat 3', 'Mã 011', 'Rảnh', '', 'Máy nhà'],
//   ['12Valorantime#12Pro', 'plat 1', 'Mã 012', 'Bận', '', 'Máy net'],
//   ['13Valorantime#13Pro', 'sil 2', 'Mã 013', 'Bận', '', 'Máy net'],
//   ['14Valorantime#14Pro', 'gold 2', 'Mã 014', 'Bận', '', 'Máy net'],
//   ['16Valorantime#16Pro', 'gold 2', 'Mã 016', 'Rảnh', '', 'Máy nhà'],
//   ['17Valorantime#17Pro', 'plat 1', 'Mã 017', 'Bận', '', 'Máy nhà'],
//   ['18Valorantime#18Pro', 'gold 3', 'Mã 018', 'Bận', '', 'Máy nhà'],
//   ['19Valorantime#19Pro', 'plat 2', 'Mã 019', 'Bận', '', 'Máy nhà'],
//   ['20Valorantime#20Pro', 'gold 3', 'Mã 020', 'Rảnh', '', 'Máy nhà'],
//   ['21Valorantime#21Pro', 'plat 1', 'Mã 021', 'Bận', '', 'Máy nhà'],
//   ['22Valorantime#22Pro', 'plat 1', 'Mã 022', 'Bận', '', 'Máy net'],
//   ['24Valorantime#24Pro', 'plat 1', 'Mã 024', 'Rảnh', '', 'Máy nhà'],
//   ['crusch#0512', 'kc 2', 'Mã 025', 'Rảnh', '', 'Máy nhà'],
// ];

// // Thêm tài khoản game mới
// $stmt = $db->prepare("INSERT INTO game_accounts (acc_name, rank, game_code, [status], [description], device_type) VALUES (?, ?, ?, ?, ?, ?)");
// foreach ($accounts as $acc) {
//   $stmt->execute($acc);
// }

// $password = password_hash('123456', PASSWORD_DEFAULT);
// $stmt = $db->prepare("UPDATE users SET [password] = ? WHERE username = ?");
// $stmt->execute([$password, 'admin']);

echo ">>> Database updated.";
