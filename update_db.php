<?php

declare(strict_types=1);

$db = new PDO('sqlite:' . __DIR__ . '/database/app.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Tạo bảng mới với ràng buộc CHECK trên cột vi_tri
$db->exec("CREATE TABLE IF NOT EXISTS new_game_accounts (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  acc_name TEXT NOT NULL,
  rank TEXT NOT NULL,
  game_code TEXT NOT NULL,
  [status] TEXT NOT NULL DEFAULT 'Rảnh' CHECK([status] IN ('Rảnh', 'Bận')),
  [description] TEXT,
  device_type TEXT NOT NULL CHECK(device_type IN ('Máy nhà', 'Tất cả')),
  avatar TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  rent_to_time DATETIME
)");

// 4. Sao chép dữ liệu từ bảng cũ sang bảng mới
$db->exec("INSERT INTO new_game_accounts (id, acc_name, rank, game_code, [status], [description], device_type, avatar, created_at, updated_at, rent_to_time)
SELECT id, acc_name, rank, game_code, [status], [description], device_type, avatar, created_at, updated_at, rent_to_time FROM game_accounts");

// 5. Xóa bảng cũ
$db->exec("DROP TABLE game_accounts");

// 6. Đổi tên bảng mới thành tên cũ
$db->exec("ALTER TABLE new_game_accounts RENAME TO game_accounts");
