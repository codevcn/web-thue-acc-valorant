<?php

declare(strict_types=1);

namespace Services;

use PDO;

class SaleAccountService
{
  private $db;
  const LIMIT = 5;

  public function __construct(PDO $db)
  {
    $this->db = $db;
  }

  public function countAll(): int
  {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM sale_accounts");
    $stmt->execute();
    return (int) $stmt->fetchColumn();
  }

  // Fetch with pagination
  public function advancedFetchAccounts(
    int $page = 1,
    int $limit = self::LIMIT
  ): array {
    $sql = "SELECT * FROM sale_accounts";

    $offset = ($page - 1) * $limit;
    $sql .= " LIMIT $limit OFFSET $offset";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
