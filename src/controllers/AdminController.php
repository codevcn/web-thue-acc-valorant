<?php

declare(strict_types=1);

namespace Controllers;

use Services\UserService;
use Services\AuthService;
use Services\RulesService;

class AdminController
{
  private $userService;
  private $authService;
  private $rulesService;

  public function __construct(UserService $userService, AuthService $authService, RulesService $rulesService)
  {
    $this->userService = $userService;
    $this->authService = $authService;
    $this->rulesService = $rulesService;
  }

  public function showManageGameAccountsPage(): void
  {
    $auth = $this->authService->verifyAuth();
    $admin = $this->userService->findAdminById($auth['user']['id']);

    $data = [
      'admin' => $admin,
      'auth' => $auth
    ];
    extract($data);

    require_once __DIR__ . '/../views/admin/manage_game_accounts/page.php';
  }

  public function showProfilePage(): void
  {
    $auth = $this->authService->verifyAuth();
    $admin = $this->userService->findAdminById($auth['user']['id']);
    $rules = $this->rulesService->findRules();

    $data = [
      'admin' => $admin,
      'auth' => $auth,
      'rules' => $rules
    ];
    extract($data);

    require_once __DIR__ . '/../views/admin/profile/page.php';
  }
}
