<?php

declare(strict_types=1);

use Controllers\Apis\GameAccountApiController;
use Services\GameAccountService;

// Initialize API controller
$apiController = new GameAccountApiController(new GameAccountService($db));

// API Routes
$apiRouter->get('/api/v1/game-accounts/load-more', function () use ($apiController) {
  return $apiController->loadMoreAccounts();
});

$apiRouter->get('/api/v1/game-accounts/rank-types', function () use ($apiController) {
  return $apiController->getAccountRankTypes();
});

$apiRouter->get('/api/v1/game-accounts/statuses', function () use ($apiController) {
  return $apiController->getAccountStatuses();
});
