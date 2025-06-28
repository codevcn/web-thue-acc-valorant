<?php

declare(strict_types=1);

namespace Services;

use PDO;
use Utils\DevLogger;

class GameAccountService
{
  private $db;
  private const LIMIT = 10;

  public function __construct(PDO $db)
  {
    $this->db = $db;
  }

  public function countAll(): int
  {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM game_accounts");
    $stmt->execute();
    return (int) $stmt->fetchColumn();
  }

  public function fetchAccounts(?int $lastId = null, ?string $rank = null, ?string $status = null, ?string $device_type = null): array
  {
    $sql = "SELECT * FROM game_accounts";
    $conditions = [];
    $params = [];
    if ($lastId !== null) {
      $conditions[] = 'id < :last_id';
      $params[':last_id'] = $lastId;
    }
    if ($rank !== null) {
      $conditions[] = 'rank = :rank';
      $params[':rank'] = $rank;
    }
    if ($status !== null) {
      $conditions[] = 'status = :status';
      $params[':status'] = $status;
    }
    if ($device_type !== null) {
      $conditions[] = 'device_type = :device_type';
      $params[':device_type'] = $device_type;
    }
    if (!empty($conditions)) {
      $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY id DESC LIMIT " . self::LIMIT;
    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
      $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchAccountRankTypes(): array
  {
    $stmt = $this->db->prepare("SELECT DISTINCT `rank` FROM game_accounts");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchAccountStatuses(): array
  {
    $stmt = $this->db->prepare("SELECT DISTINCT `status` FROM game_accounts");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchDeviceTypes(): array
  {
    $stmt = $this->db->prepare("SELECT DISTINCT `device_type` FROM game_accounts");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function addNewAccounts(array $data): void
  {
    DevLogger::log("add new accounts: " . json_encode($data));
    $sql = "INSERT INTO game_accounts (acc_name, rank, game_code, `status`, `description`, device_type)
        VALUES (:acc_name, :rank, :game_code, :status, :description, :device_type)";

    $this->db->beginTransaction();
    $stmt = $this->db->prepare($sql);

    foreach ($data as $row) {
      $accName     = $row['accName'] ?? null;
      $rank        = $row['rank'] ?? null;
      $gameCode    = $row['gameCode'] ?? null;
      $status      = $row['status'] ?? 'AVAILABLE';
      $description = $row['description'] ?? '';
      $deviceType  = $row['deviceType'] ?? null;

      // Kiểm tra bắt buộc
      if (!$accName || !$rank || !$gameCode) {
        throw new \InvalidArgumentException("Thiếu trường bắt buộc khi thêm account.");
      }

      $stmt->bindValue(':acc_name', $accName);
      $stmt->bindValue(':rank', $rank);
      $stmt->bindValue(':game_code', $gameCode);
      $stmt->bindValue(':status', $status);
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':device_type', $deviceType);

      $stmt->execute();
    }

    $this->db->commit();
  }
}
