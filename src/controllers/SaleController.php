<?php

declare(strict_types=1);

namespace Controllers;

use Services\SaleAccountService;

class SaleController
{
  private $saleAccountService;

  public function __construct(SaleAccountService $saleAccountService)
  {
    $this->saleAccountService = $saleAccountService;
  }

  public function showSalePage(): void
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : SaleAccountService::LIMIT;

    $saleAccounts = $this->saleAccountService->advancedFetchAccounts($page, $limit);

    $totalPages = ceil($this->saleAccountService->countAll() / $limit);

    $data = [
      'sale_accounts' => $saleAccounts,
      'total_pages' => $totalPages,
    ];

    extract($data);

    require_once __DIR__ . '/../views/sale/page.php';
  }
}
