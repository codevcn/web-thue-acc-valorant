<?php

declare(strict_types=1);

use Controllers\HomeController;
use Controllers\AdminController;
use Controllers\AuthController;
use Controllers\SaleController;

use Core\AuthMiddleware;
use Core\UserMiddleware;

use Services\JwtService;
use Services\AuthService;
use Services\RulesService;
use Services\UserService;
use Services\SaleAccountService;

// Initialize services
$jwtService = new JwtService();
$authService = new AuthService($db, $jwtService);
$userService = new UserService($db);
$rulesService = new RulesService($db);
$saleAccountService = new SaleAccountService($db);

// Initialize controllers
$homeController = new HomeController($userService, $rulesService);
$adminController = new AdminController($userService, $authService, $rulesService);
$authController = new AuthController($authService);
$saleController = new SaleController($saleAccountService, $rulesService, $userService);

// Initialize middleware
$authMiddleware = new AuthMiddleware($authService);
$userMiddleware = new UserMiddleware();

// Define routes
$router->get('/', function () use ($homeController, $userMiddleware) {
	$userMiddleware->checkIsFirstVisit();
	$homeController->showHomePage();
});

// Auth routes
$router->get('/admin/login', function () use ($authController, $userMiddleware) {
	$userMiddleware->checkIsFirstVisit();
	$authController->showLoginPage();
});

// Protected admin routes
$router->get('/admin/manage-game-accounts', function () use ($adminController, $authMiddleware, $userMiddleware) {
	$userMiddleware->checkIsFirstVisit();
	$authMiddleware->handle();
	$adminController->showManageGameAccountsPage();
});

$router->get('/admin/profile', function () use ($adminController, $authMiddleware, $userMiddleware) {
	$userMiddleware->checkIsFirstVisit();
	$authMiddleware->handle();
	$adminController->showProfilePage();
});

$router->get('/intro', function () use ($homeController) {
	$homeController->showIntroPage();
});

$router->get('/sale', function () use ($saleController) {
	$saleController->showSalePage();
});
