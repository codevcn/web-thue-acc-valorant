<?php

declare(strict_types=1);

use Controllers\Apis\GameAccountApiController;
use Services\GameAccountService;
use Services\FileService;
use Services\UserService;
use Controllers\Apis\AdminApiController;

// Initialize API controller
$gameAccountApiController = new GameAccountApiController(new GameAccountService($db), new FileService());
$adminApiController = new AdminApiController(new UserService($db));

// API Routes
$apiRouter->get('/api/v1/game-accounts/load-more', function () use ($gameAccountApiController) {
  return $gameAccountApiController->loadMoreAccounts();
});

$apiRouter->get('/api/v1/game-accounts/rank-types', function () use ($gameAccountApiController) {
  return $gameAccountApiController->getAccountRankTypes();
});

$apiRouter->get('/api/v1/game-accounts/statuses', function () use ($gameAccountApiController) {
  return $gameAccountApiController->getAccountStatuses();
});

$apiRouter->get('/api/v1/game-accounts/device-types', function () use ($gameAccountApiController) {
  return $gameAccountApiController->getDeviceTypes();
});

$apiRouter->post('/api/v1/game-accounts/add-new', function () use ($gameAccountApiController) {
  return $gameAccountApiController->addNewAccounts();
});

$apiRouter->post('/api/v1/game-accounts/update/{accountId}', function ($accountId) use ($gameAccountApiController) {
  return $gameAccountApiController->updateAccount($accountId);
});

$apiRouter->delete('/api/v1/game-accounts/delete/{accountId}', function ($accountId) use ($gameAccountApiController) {
  return $gameAccountApiController->deleteAccount($accountId);
});

$apiRouter->post('/api/v1/admin/update-profile', function () use ($adminApiController) {
  return $adminApiController->updateAdmin();
});
