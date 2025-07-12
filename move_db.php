<?php

declare(strict_types=1);

$db = new PDO('sqlite:' . __DIR__ . '/database/app.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Tạo bảng mới với ràng buộc CHECK trên cột vi_tri
$db->exec("CREATE TABLE IF NOT EXISTS new_rules (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  rent_acc_rules TEXT NOT NULL,
  commitment TEXT NOT NULL,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// 4. Sao chép dữ liệu từ bảng cũ sang bảng mới
// $db->exec("INSERT INTO new_rules (id, rent_acc_rules, commitment, updated_at)
// SELECT id, rent_acc_rules, updated_at FROM rules");

// 5. Xóa bảng cũ
$db->exec("DROP TABLE rules");

// 6. Đổi tên bảng mới thành tên cũ
$db->exec("ALTER TABLE new_rules RENAME TO rules");
