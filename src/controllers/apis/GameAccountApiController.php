<?php

declare(strict_types=1);

namespace Controllers\Apis;

use Services\GameAccountService;

class GameAccountApiController
{
  private $gameAccountService;

  public function __construct(GameAccountService $gameAccountService)
  {
    $this->gameAccountService = $gameAccountService;
  }

  public function loadMoreAccounts(): array
  {
    $last_id = isset($_GET['last_id']) ? (int) $_GET['last_id'] : null;
    $rank = isset($_GET['rank']) ? trim($_GET['rank']) : null;
    $status = isset($_GET['status']) ? trim($_GET['status']) : null;
    $device_type = isset($_GET['device_type']) ? trim($_GET['device_type']) : null;
    $search_term = isset($_GET['search_term']) ? trim($_GET['search_term']) : null;
    $date_from = isset($_GET['date_from']) ? trim($_GET['date_from']) : null;
    $date_to = isset($_GET['date_to']) ? trim($_GET['date_to']) : null;

    $accounts = $this->gameAccountService->advancedFetchAccounts($last_id, $rank, $status, $device_type, $search_term, $date_from, $date_to);

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

    if (count($accounts) == 1) {
      // Lấy account record vừa insert
      $latestAccount = $this->gameAccountService->getLatestAccount();

      if (!$latestAccount) {
        http_response_code(500);
        return [
          'success' => false,
          'message' => 'Không thể lấy thông tin tài khoản vừa tạo'
        ];
      }

      // Xử lý file avatar
      $avatarFile = $_FILES['avatar'];
      if ($avatarFile['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => 'Upload file avatar thất bại'
        ];
      }

      $latestAccountId = $latestAccount['id'];
      try {
        $avatarInfo = $this->gameAccountService->saveAvatarImage($avatarFile, $latestAccountId);
        $imgName = $avatarInfo['fileName'];
        $this->gameAccountService->updateAccount($latestAccountId, [
          'id' => $latestAccountId,
          'avatar' => $imgName,
        ]);
      } catch (\Throwable $th) {
        $this->gameAccountService->deleteAvatarImage($imgName);
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
    $rawInput = file_get_contents("php://input");
    if (!$rawInput) {
      http_response_code(400);
      return [
        'success' => false,
        'message' => 'Dữ liệu không hợp lệ'
      ];
    }

    $data = json_decode($rawInput, true);
    $account = $data['account'] ?? [];

    try {
      $this->gameAccountService->updateAccount($accountId, $account);
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

  public function deleteAccount(string $accountId): array
  {
    try {
      $this->gameAccountService->deleteAccount($accountId);
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
