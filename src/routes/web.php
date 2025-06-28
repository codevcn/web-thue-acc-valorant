<?php

declare(strict_types=1);

use Controllers\HomeController;
use Controllers\AdminController;
use Services\UserService;

// Initialize controllers
$homeController = new HomeController(new UserService($db));
$adminController = new AdminController(new UserService($db));

// Define routes
$router->get('/', function () use ($homeController) {
    $homeController->showHomePage();
});

$router->get('/admin/manage-game-accounts', function () use ($adminController) {
    $adminController->showManageGameAccountsPage();
});
