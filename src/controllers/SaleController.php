<?php

declare(strict_types=1);

namespace Controllers;

use Services\SaleAccountService;
use Services\RulesService;
use Services\UserService;

class SaleController
{
  private $saleAccountService;
  private $rulesService;
  private $userService;

  public function __construct(SaleAccountService $saleAccountService, RulesService $rulesService, UserService $userService)
  {
    $this->saleAccountService = $saleAccountService;
    $this->rulesService = $rulesService;
    $this->userService = $userService;
  }

  public function showSalePage(): void
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : SaleAccountService::LIMIT;

    $saleAccounts = $this->saleAccountService->advancedFetchAccounts($page, $limit);
    $accountsCount = count($saleAccounts);
    $admin = $this->userService->findAdmin();

    $rules = $this->rulesService->findRules();

    $totalPages = ceil($this->saleAccountService->countAll() / $limit);

    $data = [
      'sale_accounts' => $saleAccounts,
      'total_pages' => $totalPages,
      'current_page' => $page,
      'slides_count' => $accountsCount > $limit ? $limit : $accountsCount,
      'rules' => $rules,
    ];

    extract($data);

    require_once __DIR__ . '/../views/sale/page.php';
  }
}
