<?php

declare(strict_types=1);

namespace Services;

use PDO;

class GameAccountService
{
  private $db;

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

  public function findByPageAndFilter(int $page, int $limit, ?string $rank = null, ?string $status = null, ?string $device_type = null): array
  {
    $sql = "SELECT * FROM game_accounts";
    $conditions = [];
    $params = [];
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
    $offset = ($page - 1) * $limit;
    $sql .= " LIMIT :limit OFFSET :offset";
    $params[':limit'] = $limit;
    $params[':offset'] = $offset;
    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
      $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
