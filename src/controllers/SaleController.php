<?php

declare(strict_types=1);

namespace Controllers;

class SaleController
{
  public function __construct() {}

  public function showSalePage(): void
  {
    require_once __DIR__ . '/../views/sale/page.php';
  }
}
