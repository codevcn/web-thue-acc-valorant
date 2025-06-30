<?php

declare(strict_types=1);

use Controllers\Apis\GameAccountApiController;
use Services\GameAccountService;
use Services\FileService;
use Services\UserService;
use Controllers\Apis\AdminApiController;
use Controllers\Apis\AuthApiController;
use Services\AuthService;
use Services\JwtService;
use Core\AuthMiddleware;
use Services\RulesService;

// Initialize API controller
$gameAccountApiController = new GameAccountApiController(new GameAccountService($db), new FileService());
$adminApiController = new AdminApiController(new UserService($db), new RulesService($db));
$authApiController = new AuthApiController(new AuthService($db, new JwtService()));
$authService = new AuthService($db, new JwtService());

// Initialize middleware
$authMiddleware = new AuthMiddleware($authService);

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

$apiRouter->post('/api/v1/game-accounts/add-new', function () use ($gameAccountApiController, $authMiddleware) {
  $authMiddleware->handle();
  return $gameAccountApiController->addNewAccounts();
});

$apiRouter->post('/api/v1/game-accounts/update/{accountId}', function ($accountId) use ($gameAccountApiController, $authMiddleware) {
  $authMiddleware->handle();
  return $gameAccountApiController->updateAccount($accountId);
});

$apiRouter->delete('/api/v1/game-accounts/delete/{accountId}', function ($accountId) use ($gameAccountApiController, $authMiddleware) {
  $authMiddleware->handle();
  return $gameAccountApiController->deleteAccount($accountId);
});

$apiRouter->post('/api/v1/admin/update-profile', function () use ($adminApiController, $authMiddleware) {
  $authMiddleware->handle();
  return $adminApiController->updateAdmin();
});

$apiRouter->post('/api/v1/auth/login', function () use ($authApiController) {
  return $authApiController->login();
});

$apiRouter->get('/api/v1/auth/logout', function () use ($authApiController) {
  return $authApiController->logout();
});
