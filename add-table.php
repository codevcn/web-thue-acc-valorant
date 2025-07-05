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

$db->exec("CREATE TABLE IF NOT EXISTS `status` (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  [type] TEXT NOT NULL
)");

$db->exec("INSERT INTO `status` ([type]) 
VALUES 
('Rảnh'),
('Bận')");
