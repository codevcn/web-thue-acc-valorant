<?php

declare(strict_types=1);

namespace Services;

use PDO;
use DateTime;
use DateTimeZone;
use Utils\Helper;

class GameAccountService
{
  private $db;
  private const LOAD_MORE_ACCOUNTS_PAGE_SIZE = 10;

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
    } else if ($lastId !== null) {
      $conditions[] = 'id < :last_id';
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
    $order_condition = " ORDER BY created_at DESC, id DESC LIMIT " . self::LOAD_MORE_ACCOUNTS_PAGE_SIZE;
    if ($order_type !== null) {
      if ($order_type === 'updated_at') {
        $order_condition = " ORDER BY updated_at DESC, id DESC LIMIT " . self::LOAD_MORE_ACCOUNTS_PAGE_SIZE;
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

  public function advancedFetchAccountsForAdmin(
    ?string $freeAccGameCode = null,
    ?string $checkAccGameCode = null,
    ?string $busyAccGameCode = null,
    ?string $rank = null,
    ?string $status = null,
    ?string $device_type = null,
    ?string $search_term = null,
  ): array {
    $sql_status_free = "SELECT * FROM game_accounts";
    $sql_status_check = "SELECT * FROM game_accounts";
    $sql_status_busy = "SELECT * FROM game_accounts";
    $free_conditions = [];
    $free_params = [];
    $check_conditions = [];
    $check_params = [];
    $busy_conditions = [];
    $busy_params = [];
    $common_params = [];
    $common_conditions = [];

    // Load more with id
    if ($checkAccGameCode !== null) {
      $check_conditions[] = 'game_code > :check_acc_game_code';
      $check_params[':check_acc_game_code'] = $checkAccGameCode;
    }
    if ($freeAccGameCode !== null) {
      $free_conditions[] = 'game_code > :free_acc_game_code';
      $free_params[':free_acc_game_code'] = $freeAccGameCode;
    }
    if ($busyAccGameCode !== null) {
      $busy_conditions[] = 'game_code > :busy_acc_game_code';
      $busy_params[':busy_acc_game_code'] = $busyAccGameCode;
    }

    // setup common conditions
    if ($rank !== null) {
      $common_conditions[] = 'rank LIKE :rank';
      $common_params[':rank'] = $rank . '%';
    }
    if ($status !== null) {
      $common_conditions[] = 'status = :status';
      $common_params[':status'] = $status;
    }
    if ($device_type !== null) {
      $common_conditions[] = 'device_type = :device_type';
      $common_params[':device_type'] = $device_type;
    }
    if ($search_term !== null) {
      $common_conditions[] = '(acc_name LIKE :search_term OR game_code LIKE :search_term OR `description` LIKE :search_term)';
      $common_params[':search_term'] = '%' . $search_term . '%';
    }

    $common_conditions_are_not_empty = !empty($common_conditions);

    // put conditions into where clause
    if ($common_conditions_are_not_empty) {
      $sql_status_free .= " WHERE " . implode(' AND ', $common_conditions) . " AND `status` = 'Rảnh'";
      $sql_status_check .= " WHERE " . implode(' AND ', $common_conditions) . " AND `status` = 'Check'";
      $sql_status_busy .= " WHERE " . implode(' AND ', $common_conditions) . " AND `status` = 'Bận'";
    } else {
      $sql_status_free .= " WHERE `status` = 'Rảnh'";
      $sql_status_check .= " WHERE `status` = 'Check'";
      $sql_status_busy .= " WHERE `status` = 'Bận'";
    }

    // add conditions for free, check, busy
    if (!empty($free_conditions)) {
      $sql_status_free .= " AND " . implode(' AND ', $free_conditions);
    }
    if (!empty($check_conditions)) {
      $sql_status_check .= " AND " . implode(' AND ', $check_conditions);
    }
    if (!empty($busy_conditions)) {
      $sql_status_busy .= " AND " . implode(' AND ', $busy_conditions);
    }

    // setup order
    $order_condition = " ORDER BY game_code ASC LIMIT " . self::LOAD_MORE_ACCOUNTS_PAGE_SIZE;
    $sql_status_busy .= $order_condition;
    $sql_status_check .= $order_condition;
    $sql_status_free .= $order_condition;

    // complete sql
    $sql = "SELECT * FROM (
      SELECT * FROM (" . $sql_status_check . ") 
      UNION ALL 
      SELECT * FROM (" . $sql_status_free . ") 
      UNION ALL 
      SELECT * FROM (" . $sql_status_busy . ")
    ) LIMIT " . self::LOAD_MORE_ACCOUNTS_PAGE_SIZE;

    $stmt = $this->db->prepare($sql);
    foreach ($common_params as $key => $value) {
      $stmt->bindValue($key, $value);
    }
    foreach ($free_params as $key => $value) {
      $stmt->bindValue($key, $value);
    }
    foreach ($check_params as $key => $value) {
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
    return Helper::getNowWithTimezone();
  }

  public function addNewAccounts(array $data): ?int
  {
    $sql = "INSERT INTO game_accounts (acc_name, acc_username, rank, game_code, `status`, `description`, device_type, created_at, updated_at)
            VALUES (:acc_name, :acc_username, :rank, :game_code, :status, :description, :device_type, :created_at, :updated_at)";
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
        $accUsername = $row['accUsername'] ?? null;

        if (!$accName) {
          throw new \InvalidArgumentException("Trường tên tài khoản không được để trống.");
        }
        if (!$rank) {
          throw new \InvalidArgumentException("Trường rank không được để trống.");
        }
        if (!$gameCode) {
          throw new \InvalidArgumentException("Trường mã game không được để trống.");
        }
        if (!$deviceType) {
          throw new \InvalidArgumentException("Trường loại máy không được để trống.");
        }
        if (!$status) {
          throw new \InvalidArgumentException("Trường trạng thái không được để trống.");
        }
        if (!$accUsername) {
          throw new \InvalidArgumentException("Trường tên đăng nhập không được để trống.");
        }

        $stmt->bindValue(':acc_name', $accName);
        $stmt->bindValue(':acc_username', $accUsername);
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

  public function validateRentToTime(string $rentToTime): void
  {
    $now = new \DateTime($this->getNow(), new \DateTimeZone('Asia/Ho_Chi_Minh'));
    $rentToTimeObj = \DateTime::createFromFormat('Y-m-d H:i:s', $rentToTime, new \DateTimeZone('Asia/Ho_Chi_Minh'));
    if (!$rentToTimeObj) {
      throw new \InvalidArgumentException("Thời gian thuê không hợp lệ.");
    }
    if ($rentToTimeObj < $now) {
      throw new \InvalidArgumentException("Thời gian kết thúc thuê phải lớn hơn thời gian hiện tại.");
    }
  }

  public function updateAccount(int $accountId, array $data): void
  {
    // Kiểm tra tài khoản có tồn tại không
    $account = $this->findAccountById($accountId);
    if (!$account) {
      throw new \InvalidArgumentException("Tài khoản không tồn tại.");
    }

    $accName     = $data['accName'] ?? null;
    $rank        = $data['rank'] ?? null;
    $gameCode    = $data['gameCode'] ?? null;
    $status      = $data['status'] ?? null;
    $description = $data['description'] ?? null;
    $deviceType  = $data['deviceType'] ?? null;
    $avatar      = $data['avatar'] ?? null;
    $rentToTime  = $data['rentToTime'] ?? null;
    $accUsername = $data['accUsername'] ?? null;

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
      if ($status !== 'Bận' && $this->checkAccountIsRenting($account)) {
        throw new \InvalidArgumentException("Tài khoản đang được thuê, không thể cập nhật trạng thái.");
      }
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
    if ($rentToTime !== null) {
      $this->validateRentToTime($rentToTime);
      if (!$account['rent_from_time']) {
        if ($account['status'] !== 'Rảnh') {
          throw new \InvalidArgumentException("Tài khoản phải ở trạng thái rảnh.");
        }
      }
      $updateFields[] = "`status` = :status";
      $params[':status'] = "Bận";
      if ($account['rent_from_time'] === null) {
        $updateFields[] = "rent_from_time = :rent_from_time";
        $params[':rent_from_time'] = $this->getNow();
      }
      $updateFields[] = "rent_to_time = :rent_to_time";
      $params[':rent_to_time'] = $rentToTime;
    }
    if ($accUsername !== null) {
      $updateFields[] = "acc_username = :acc_username";
      $params[':acc_username'] = $accUsername;
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

  public function updateAccountRentTime(): void
  {
    $now = $this->getNow();

    $sql = "
        UPDATE game_accounts
        SET `status` = 'Check',
            updated_at = :now,
            rent_from_time = NULL,
            rent_to_time = NULL
        WHERE rent_to_time IS NOT NULL
          AND rent_to_time < :now
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':now' => $now]);
  }

  public function checkAccountIsRenting(array $account): bool
  {
    $rentFromTime = $account['rent_from_time'] ?? null;
    $rentToTime   = $account['rent_to_time'] ?? null;

    if ($rentFromTime === null || $rentToTime === null) {
      return false;
    }

    $nowString = $this->getNow();
    $now = DateTime::createFromFormat('Y-m-d H:i:s', $nowString, new DateTimeZone('Asia/Ho_Chi_Minh'));
    $from = DateTime::createFromFormat('Y-m-d H:i:s', $account['rent_from_time'], new DateTimeZone('Asia/Ho_Chi_Minh'));
    $to   = DateTime::createFromFormat('Y-m-d H:i:s', $account['rent_to_time'], new DateTimeZone('Asia/Ho_Chi_Minh'));

    if ($now && $from && $to) {
      if ($now >= $from && $now <= $to) {
        return true;
      }
    }

    return false;
  }

  public function switchAccountStatus(int $accountId, string $status): void
  {
    $this->updateAccount($accountId, [
      'status' => $status,
    ]);
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

  public function refreshAccount(int $accountId): array
  {
    $account = $this->findAccountById($accountId);
    if (!$account) {
      throw new \InvalidArgumentException("Tài khoản không tồn tại.");
    }

    return $account;
  }

  public function cancelRent(int $accountId): void
  {
    $account = $this->findAccountById($accountId);
    if (!$account) {
      throw new \InvalidArgumentException("Tài khoản không tồn tại.");
    }
    $sql = "UPDATE game_accounts SET `status` = 'Check', updated_at = :updated_at, rent_from_time = NULL, rent_to_time = NULL WHERE id = :id";
    $params = [
      ':id' => $accountId,
      ':updated_at' => $this->getNow()
    ];
    $stmt = $this->db->prepare($sql);
    foreach ($params as $param => $value) {
      $stmt->bindValue($param, $value);
    }
    $stmt->execute();
  }

  public function switchDeviceType(int $accountId): void
  {
    $account = $this->findAccountById($accountId);
    if (!$account) {
      throw new \InvalidArgumentException("Tài khoản không tồn tại.");
    }

    $sql = "UPDATE game_accounts SET device_type = :device_type, updated_at = :updated_at WHERE id = :id";
    $params = [
      ':id' => $accountId,
      ':device_type' => $account['device_type'] === 'Tất cả' ? 'Máy nhà' : 'Tất cả',
      ':updated_at' => $this->getNow()
    ];
    $stmt = $this->db->prepare($sql);
    foreach ($params as $param => $value) {
      $stmt->bindValue($param, $value);
    }
    $stmt->execute();
  }
}
