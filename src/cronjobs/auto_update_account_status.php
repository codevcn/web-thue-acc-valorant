<?php

require_once __DIR__ . '/../../vendor/autoload.php';
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Set timezone

use Utils\DevLogger;

$databasePath = __DIR__ . '/../../database/app.sqlite';

try {
  $pdo = new PDO("sqlite:$databasePath");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $now = date('Y-m-d H:i:s');

  $sql = "
        UPDATE game_accounts
        SET status = 'Rảnh',
            updated_at = :now
        WHERE status = 'Bận'
          AND rent_to_time IS NOT NULL
          AND rent_to_time < :now
    ";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([':now' => $now]);

  $count = $stmt->rowCount();

  DevLogger::log("[" . $now . "] Updated $count account(s) status to 'Rảnh'.");
} catch (PDOException $e) {
  DevLogger::log("[" . date('Y-m-d H:i:s') . "] Database error: " . $e->getMessage());
}
