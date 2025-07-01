<?php
try {
  // Kết nối đến SQLite
  $db = new PDO('sqlite:' . __DIR__ . '/database/app.sqlite');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Bắt đầu transaction
  $db->beginTransaction();

  // Tạo bảng mới (có thể sửa đổi tùy yêu cầu)
  $db->exec("CREATE TABLE IF NOT EXISTS new_game_accounts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    acc_name TEXT NOT NULL,
    rank TEXT NOT NULL,
    game_code TEXT NOT NULL,
    [status] TEXT NOT NULL,
    [description] TEXT,
    device_type TEXT NOT NULL,
    avatar TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
  )");

  // Chuyển dữ liệu từ bảng cũ sang bảng mới
  $copyDataSQL = "
        INSERT INTO new_game_accounts (id, acc_name, rank, game_code, [status], [description], device_type, avatar)
        SELECT id, acc_name, rank, game_code, [status], [description], device_type, avatar FROM game_accounts;
    ";
  $db->exec($copyDataSQL);

  // Xóa bảng cũ
  $db->exec("DROP TABLE game_accounts;");

  // Đổi tên bảng mới thành tên cũ
  $db->exec("ALTER TABLE new_game_accounts RENAME TO game_accounts;");

  // Commit transaction
  $db->commit();

  echo "✅ Dữ liệu đã được chuyển thành công.";
} catch (Exception $e) {
  // Rollback nếu có lỗi
  $db->rollBack();
  echo "❌ Lỗi: " . $e->getMessage();
}
