<?php

declare(strict_types=1);

namespace Services;

use PDO;
use Utils\DevLogger;

class UserService
{
  private $db;

  public function __construct(PDO $db)
  {
    $this->db = $db;
  }

  public function findAdmin(): array
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'ADMIN'");
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    DevLogger::logToFile(json_encode($res));
    return $res;
  }
}
