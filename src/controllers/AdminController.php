<?php

declare(strict_types=1);

namespace Controllers;

use Services\GameAccountService;
use Services\UserService;

class AdminController
{
  private $gameAccountService;
  private $userService;

  public function __construct(GameAccountService $gameAccountService, UserService $userService)
  {
    $this->gameAccountService = $gameAccountService;
    $this->userService = $userService;
  }

  public function showAdminPage(): void
  {
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
    $rank = isset($_GET['rank']) ? $_GET['rank'] : null;
    $status = isset($_GET['status']) ? $_GET['status'] : null;
    $device_type = isset($_GET['device_type']) ? $_GET['device_type'] : null;

    $accounts = $this->gameAccountService->findByPageAndFilter($page, $limit, $rank, $status, $device_type);

    $total = $this->gameAccountService->countAll();
    $total_pages = (int) ceil($total / $limit);

    $admin = $this->userService->findAdmin();

    $data = [
      'accounts' => $accounts,
      'total_pages' => $total_pages,
      'page' => $page,
      'limit' => $limit,
      'admin' => $admin
    ];
    extract($data);

    require_once __DIR__ . '/../views/admin/page.php';
  }
}
