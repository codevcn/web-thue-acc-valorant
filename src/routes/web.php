<?php

declare(strict_types=1);

use Controllers\HomeController;
use Services\GameAccountService;
use Services\UserService;

// Initialize controllers
$homeController = new HomeController(new GameAccountService($db), new UserService($db));

// Define routes
$router->get('/', function () use ($homeController) {
    $homeController->showHomePage();
});
