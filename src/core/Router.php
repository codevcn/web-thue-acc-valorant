<?php

declare(strict_types=1);

namespace Core;

class Router
{
  private array $routes = [];

  public function get(string $path, callable $handler): void
  {
    $this->routes['GET'][$path] = $handler;
  }

  public function post(string $path, callable $handler): void
  {
    $this->routes['POST'][$path] = $handler;
  }

  public function dispatch(string $method, string $uri): mixed
  {
    $path = parse_url($uri, PHP_URL_PATH);

    if (isset($this->routes[$method][$path])) {
      return call_user_func($this->routes[$method][$path]);
    }

    // Handle 404
    http_response_code(404);
    return '404 Not Found';
  }
}
