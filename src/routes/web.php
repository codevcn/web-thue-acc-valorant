<?php

declare(strict_types=1);

use Controllers\HomeController;
use Services\UserService;

// Initialize controllers
$homeController = new HomeController(new UserService($db));

// Define routes
$router->get('/', function () use ($homeController) {
    $homeController->showHomePage();
});
