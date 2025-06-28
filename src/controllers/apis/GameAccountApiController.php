<?php

declare(strict_types=1);

namespace Controllers\Apis;

use Services\GameAccountService;
use Utils\DevLogger;

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

    $accounts = $this->gameAccountService->fetchAccounts($last_id, $rank, $status, $device_type);

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
    $rawInput = file_get_contents("php://input");
    if (!$rawInput) {
      http_response_code(400);
      return [
        'success' => false,
        'message' => 'Invalid input data'
      ];
    }

    $data = json_decode($rawInput, true);
    $accounts = $data['accounts'] ?? [];

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
        'message' => 'Internal server error'
      ];
    }

    return [
      'success' => true,
    ];
  }
}
