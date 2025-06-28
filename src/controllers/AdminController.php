<?php

declare(strict_types=1);

namespace Controllers;

use Services\UserService;

class AdminController
{
  private $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function showManageGameAccountsPage(): void
  {
    $admin = $this->userService->findAdmin();

    $data = [
      'admin' => $admin
    ];
    extract($data);

    require_once __DIR__ . '/../views/admin/manage-game-accounts/page.php';
  }
}
