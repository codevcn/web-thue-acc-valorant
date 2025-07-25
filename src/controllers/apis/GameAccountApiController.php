<?php

declare(strict_types=1);

namespace Controllers\Apis;

use Services\GameAccountService;
use Services\FileService;
use Utils\DevLogger;

class GameAccountApiController
{
  private $gameAccountService;
  private $fileService;

  public function __construct(GameAccountService $gameAccountService, FileService $fileService)
  {
    $this->gameAccountService = $gameAccountService;
    $this->fileService = $fileService;
  }

  public function loadMoreAccounts(): array
  {
    $last_id = isset($_GET['last_id']) ? (int) $_GET['last_id'] : null;
    $last_updated_at = isset($_GET['last_updated_at']) ? trim($_GET['last_updated_at']) : null;
    $rank = isset($_GET['rank']) ? trim($_GET['rank']) : null;
    $status = isset($_GET['status']) ? trim($_GET['status']) : null;
    $device_type = isset($_GET['device_type']) ? trim($_GET['device_type']) : null;
    $search_term = isset($_GET['search_term']) ? trim($_GET['search_term']) : null;
    $order_type = isset($_GET['order_type']) ? trim($_GET['order_type']) : null;

    $accounts = $this->gameAccountService->advancedFetchAccounts(
      $last_id,
      $last_updated_at,
      $rank,
      $status,
      $device_type,
      $search_term,
      $order_type
    );

    return [
      'accounts' => $accounts,
    ];
  }

  public function loadMoreAccountsForAdmin(): array
  {
    $rank = isset($_GET['rank']) ? trim($_GET['rank']) : null;
    $status = isset($_GET['status']) ? trim($_GET['status']) : null;
    $device_type = isset($_GET['device_type']) ? trim($_GET['device_type']) : null;
    $search_term = isset($_GET['search_term']) ? trim($_GET['search_term']) : null;
    $order_type = isset($_GET['order_type']) ? trim($_GET['order_type']) : null;
    $busy_last_game_code = isset($_GET['busy_last_game_code']) ? trim($_GET['busy_last_game_code']) : null;
    $free_last_game_code = isset($_GET['free_last_game_code']) ? trim($_GET['free_last_game_code']) : null;
    $check_last_game_code = isset($_GET['check_last_game_code']) ? trim($_GET['check_last_game_code']) : null;

    $accounts = $this->gameAccountService->advancedFetchAccountsForAdmin(
      $free_last_game_code,
      $check_last_game_code,
      $busy_last_game_code,
      $rank,
      $status,
      $device_type,
      $search_term,
      $order_type
    );

    return [
      'accounts' => $accounts,
    ];
  }

  public function getAccountRankTypes(): array
  {
    $rankTypes = $this->gameAccountService->fetchAccountRankTypes();

    return [
      'rank_types' => $rankTypes,
    ];
  }

  public function getAccountStatuses(): array
  {
    $statuses = $this->gameAccountService->fetchAccountStatuses();

    return [
      'statuses' => $statuses,
    ];
  }

  public function getDeviceTypes(): array
  {
    $deviceTypes = $this->gameAccountService->fetchDeviceTypes();

    return [
      'device_types' => $deviceTypes,
    ];
  }

  public function addNewAccounts(): array
  {
    if (!isset($_POST['accounts'])) {
      http_response_code(400);
      return [
        'success' => false,
        'message' => 'Thiếu dữ liệu avatar hoặc accounts'
      ];
    }

    // Lấy dữ liệu tài khoản (giả sử client stringify JSON và append vào formData)
    $accountsJson = $_POST['accounts'];
    $accounts = json_decode($accountsJson, true);

    if (!is_array($accounts)) {
      http_response_code(400);
      return [
        'success' => false,
        'message' => 'Dữ liệu accounts không hợp lệ'
      ];
    }

    try {
      $this->gameAccountService->addNewAccounts($accounts);
    } catch (\Throwable $th) {
      // Bắt lỗi vi phạm UNIQUE
      if ($th->getCode() === '23000' && str_contains($th->getMessage(), 'game_code')) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => "Mã game đã tồn tại."
        ];
      }

      // Bắt lỗi vi phạm CHECK constraint trong SQLite
      if ($th instanceof \PDOException && str_contains($th->getMessage(), 'CHECK constraint failed')) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => 'Giá trị đầu vào không hợp lệ.'
        ];
      }

      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }

      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    // Xử lý file avatar
    $avatarFile = $_FILES['avatar'] ?? null;
    if (count($accounts) == 1 && $avatarFile) {
      // Lấy account record vừa insert
      $latestAccount = $this->gameAccountService->getLatestAccount();

      if (!$latestAccount) {
        http_response_code(500);
        return [
          'success' => false,
          'message' => 'Không thể lấy thông tin tài khoản vừa tạo'
        ];
      }

      $latestAccountId = $latestAccount['id'];
      $imgName = null;
      try {
        $avatarInfo = $this->fileService->saveAvatarImage($avatarFile, $latestAccountId);
        $imgName = $avatarInfo['fileName'];
        $this->gameAccountService->updateAccount($latestAccountId, [
          'avatar' => $imgName,
        ]);
      } catch (\Throwable $th) {
        $this->fileService->deleteAvatarImage($imgName);
        http_response_code(400);
        return [
          'success' => false,
          'message' => 'Tạo ảnh đại diện thất bại'
        ];
      }
    }

    return [
      'success' => true,
    ];
  }

  public function updateAccount(string $accountId): array
  {
    $accountIdInt = (int) $accountId;
    $oldAccount = $this->gameAccountService->findAccountById($accountIdInt);
    if (!$oldAccount) {
      http_response_code(404);
      return [
        'success' => false,
        'message' => 'Tài khoản không tồn tại'
      ];
    }

    if (!isset($_POST['account'])) {
      http_response_code(400);
      return [
        'success' => false,
        'message' => 'Thiếu dữ liệu account'
      ];
    }

    // Lấy dữ liệu tài khoản (giả sử client stringify JSON và append vào formData)
    $accountJson = $_POST['account'];
    $account = json_decode($accountJson, true);

    // Xử lý file avatar (nếu có)
    $avatarFile = $_FILES['avatar'] ?? null;
    $imgName = null;
    if ($avatarFile) {
      $oldAvatar = $oldAccount['avatar'];
      if ($oldAvatar) {
        $this->fileService->deleteAvatarImage($oldAvatar);
      }
      try {
        $avatarInfo = $this->fileService->saveAvatarImage($avatarFile, $accountIdInt);
        $imgName = $avatarInfo['fileName'];
      } catch (\Throwable $th) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => 'Tạo ảnh đại diện thất bại: ' . $th->getMessage()
        ];
      }

      $account['avatar'] = $imgName;
    }

    try {
      $this->gameAccountService->updateAccount($accountIdInt, $account);
    } catch (\Throwable $th) {
      if ($imgName) {
        $this->fileService->deleteAvatarImage($imgName);
      }

      if ($th->getCode() === '23000' && str_contains($th->getMessage(), 'game_code')) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => "Mã game đã tồn tại."
        ];
      }

      // Bắt lỗi vi phạm CHECK constraint trong SQLite
      if ($th instanceof \PDOException && str_contains($th->getMessage(), 'CHECK constraint failed')) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => 'Giá trị đầu vào không hợp lệ.'
        ];
      }

      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }

      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    return [
      'success' => true,
    ];
  }

  public function deleteAccount(string $accountId): array
  {
    try {
      $this->gameAccountService->deleteAccount((int) $accountId);
    } catch (\Throwable $th) {
      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }

      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    return [
      'success' => true,
    ];
  }

  public function switchAccountStatus(string $accountId): array
  {
    $status = isset($_POST['status']) ? trim($_POST['status']) : null;
    if (!$status) {
      http_response_code(400);
      return [
        'success' => false,
        'message' => 'Thiếu trạng thái'
      ];
    }
    try {
      $this->gameAccountService->switchAccountStatus((int) $accountId, $status);
    } catch (\Throwable $th) {
      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }

      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    return [
      'success' => true,
    ];
  }

  public function updateAccountRentTime(): array
  {
    try {
      $this->gameAccountService->updateAccountRentTime();
    } catch (\Throwable $th) {
      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }
      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    return [
      'success' => true,
    ];
  }

  public function fetchSingleAccount(string $accountId): array
  {
    try {
      $refreshedAccount = $this->gameAccountService->refreshAccount((int) $accountId);
    } catch (\Throwable $th) {
      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }
      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    return [
      'success' => true,
      'account' => $refreshedAccount,
    ];
  }

  public function cancelRent(string $accountId): array
  {
    try {
      $this->gameAccountService->cancelRent((int) $accountId);
    } catch (\Throwable $th) {
      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }
      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    return [
      'success' => true,
    ];
  }

  public function switchDeviceType(string $accountId): array
  {
    try {
      $this->gameAccountService->switchDeviceType((int) $accountId);
    } catch (\Throwable $th) {
      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }
      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    return [
      'success' => true,
    ];
  }
}
