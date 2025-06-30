<?php

declare(strict_types=1);

namespace Core;

class UserMiddleware
{
  private $FIRST_VISIT_COOKIE_NAME = 'not_first_visit';

  public function __construct() {}

  public function checkIsFirstVisit(): bool
  {
    $isFirstVisit = $_COOKIE[$this->FIRST_VISIT_COOKIE_NAME] ?? false;

    if (!$isFirstVisit) {
      setcookie($this->FIRST_VISIT_COOKIE_NAME, 'true', time() + 60 * 60 * 24 * 30, '/');
      header('Location: /intro');
      exit;
    }

    return true;
  }
}
