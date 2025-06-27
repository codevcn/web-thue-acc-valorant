<?php

declare(strict_types=1);

namespace Services;

use PDO;

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
}
