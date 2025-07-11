<?php

declare(strict_types=1);

namespace Services;

use PDO;
use DateTime;
use DateTimeZone;

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

  public function advancedFetchAccounts(
    ?int $lastId = null,
    ?string $lastUpdatedAt = null,
    ?string $rank = null,
    ?string $status = null,
    ?string $device_type = null,
    ?string $search_term = null,
    ?string $order_type = null
  ): array {
    $sql = "SELECT * FROM game_accounts";
    $conditions = [];
    $params = [];

    // Load more logic kết hợp updated_at + id
    if ($lastUpdatedAt !== null && $lastId !== null) {
      $conditions[] = '(updated_at < :last_updated_at OR (updated_at = :last_updated_at AND id < :last_id))';
      $params[':last_updated_at'] = $lastUpdatedAt;
      $params[':last_id'] = $lastId;
    }

    if ($rank !== null) {
      $conditions[] = 'rank LIKE :rank';
      $params[':rank'] = $rank . '%';
    }
    if ($status !== null) {
      $conditions[] = 'status = :status';
      $params[':status'] = $status;
    }
    if ($device_type !== null) {
      $conditions[] = 'device_type = :device_type';
      $params[':device_type'] = $device_type;
    }
    if ($search_term !== null) {
      $conditions[] = '(acc_name LIKE :search_term OR game_code LIKE :search_term OR `description` LIKE :search_term)';
      $params[':search_term'] = '%' . $search_term . '%';
    }

    if (!empty($conditions)) {
      $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $order_condition = " ORDER BY created_at DESC, id DESC LIMIT " . self::LIMIT;
    if ($order_type !== null) {
      if ($order_type === 'updated_at') {
        $order_condition = " ORDER BY updated_at DESC, id DESC LIMIT " . self::LIMIT;
      }
    }
    $sql .= $order_condition;

    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
      $stmt->bindValue($key, $value);
    }
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchAccountRankTypes(): array
  {
    $stmt = $this->db->prepare("SELECT * FROM `ranks`");
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

  public function getNow(): string
  {
    return (new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh')))->format('Y-m-d H:i:s');
  }

  public function addNewAccounts(array $data): ?int
  {
    $sql = "INSERT INTO game_accounts (acc_name, rank, game_code, `status`, `description`, device_type, created_at, updated_at)
            VALUES (:acc_name, :rank, :game_code, :status, :description, :device_type, :created_at, :updated_at)";
    try {

      $this->db->beginTransaction();
      $stmt = $this->db->prepare($sql);

      $now = $this->getNow();
      $insertedAccountId = null;

      foreach ($data as $row) {
        $accName     = $row['accName'] ?? null;
        $rank        = $row['rank'] ?? null;
        $gameCode    = $row['gameCode'] ?? null;
        $status      = $row['status'] ?? null;
        $description = $row['description'] ?? '';
        $deviceType  = $row['deviceType'] ?? null;

        if (!$accName || !$rank || !$gameCode || !$deviceType || !$status) {
          throw new \InvalidArgumentException("Thiếu trường bắt buộc khi thêm account.");
        }

        $stmt->bindValue(':acc_name', $accName);
        $stmt->bindValue(':rank', $rank);
        $stmt->bindValue(':game_code', $gameCode);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':device_type', $deviceType);
        $stmt->bindValue(':created_at', $now);
        $stmt->bindValue(':updated_at', $now);

        $stmt->execute();

        // Lấy ID của account vừa insert (SQLite)
        if ($insertedAccountId === null) {
          $insertedAccountId = $this->db->lastInsertId();
        }
      }

      $this->db->commit();

      return (int) $insertedAccountId;
    } catch (\PDOException $e) {
      $this->db->rollBack();

      // Các lỗi khác
      throw $e;
    }
  }

  public function updateAccount(int $accountId, array $data): void
  {
    // Kiểm tra tài khoản có tồn tại không
    if (!$this->findAccountById($accountId)) {
      throw new \InvalidArgumentException("Tài khoản không tồn tại.");
    }

    $accName     = $data['accName'] ?? null;
    $rank        = $data['rank'] ?? null;
    $gameCode    = $data['gameCode'] ?? null;
    $status      = $data['status'] ?? null;
    $description = $data['description'] ?? null;
    $deviceType  = $data['deviceType'] ?? null;
    $avatar      = $data['avatar'] ?? null;
    $rentAddTime = $data['rentAddTime'] ?? null;
    $rentToTime  = $data['rentToTime'] ?? null;

    $updateFields = [];
    $params = [];

    if ($accName !== null) {
      $updateFields[] = "acc_name = :acc_name";
      $params[':acc_name'] = $accName;
    }
    if ($rank !== null) {
      $updateFields[] = "rank = :rank";
      $params[':rank'] = $rank;
    }
    if ($gameCode !== null) {
      $updateFields[] = "game_code = :game_code";
      $params[':game_code'] = $gameCode;
    }
    if ($status !== null) {
      $updateFields[] = "`status` = :status";
      $params[':status'] = $status;
    }
    if ($description !== null) {
      $updateFields[] = "`description` = :description";
      $params[':description'] = $description;
    }
    if ($deviceType !== null) {
      $updateFields[] = "device_type = :device_type";
      $params[':device_type'] = $deviceType;
    }
    if ($avatar !== null) {
      $updateFields[] = "avatar = :avatar";
      $params[':avatar'] = $avatar;
    }
    if ($rentAddTime !== null || $rentToTime !== null) {
      $updateFields[] = "rent_from_time = :rent_from_time";
      $params[':rent_from_time'] = $this->getNow();
      $updateFields[] = "`status` = :status";
      $params[':status'] = "Bận";
      if ($rentAddTime !== null) {
        $updateFields[] = "rent_add_time = :rent_add_time";
        $params[':rent_add_time'] = $rentAddTime;
      }
      if ($rentToTime !== null) {
        $updateFields[] = "rent_to_time = :rent_to_time";
        $params[':rent_to_time'] = $rentToTime;
      }
    }
    if (empty($updateFields)) {
      throw new \InvalidArgumentException("Không có trường nào để cập nhật.");
    }
    $updateFields[] = "updated_at = :updated_at";
    $params[':updated_at'] = $this->getNow();

    $sql = "UPDATE game_accounts SET " . implode(', ', $updateFields) . " WHERE id = :id";
    $params[':id'] = $accountId;

    try {
      $this->db->beginTransaction();

      $stmt = $this->db->prepare($sql);
      foreach ($params as $param => $value) {
        $stmt->bindValue($param, $value);
      }

      $stmt->execute();
      $this->db->commit();
    } catch (\Throwable $e) {
      $this->db->rollBack();
      throw $e;
    }
  }

  public function deleteAccount(int $accountId): void
  {
    if (!$this->findAccountById($accountId)) {
      throw new \InvalidArgumentException("Tài khoản không tồn tại.");
    }

    $stmt = $this->db->prepare("DELETE FROM game_accounts WHERE id = :id");
    $stmt->bindValue(':id', $accountId);
    $stmt->execute();
  }

  public function getLatestAccount(): array
  {
    $stmt = $this->db->prepare("SELECT * FROM game_accounts ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findAccountById(int $accountId): ?array
  {
    $stmt = $this->db->prepare("SELECT * FROM game_accounts WHERE id = :id");
    $stmt->bindValue(':id', $accountId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function findAccountByGameCode(string $gameCode): ?array
  {
    $stmt = $this->db->prepare("SELECT * FROM game_accounts WHERE game_code = :game_code");
    $stmt->bindValue(':game_code', $gameCode);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }
}
