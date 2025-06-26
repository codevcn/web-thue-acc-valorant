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
}
