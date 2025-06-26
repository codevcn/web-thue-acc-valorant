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

    require_once __DIR__ . '/../views/admin/page.php';
  }
}
