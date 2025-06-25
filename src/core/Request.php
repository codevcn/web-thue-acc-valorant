<?php

declare(strict_types=1);

namespace Core;

class Request
{
  public function getMethod(): string
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function getUri(): string
  {
    return $_SERVER['REQUEST_URI'];
  }

  public function get(string $key, mixed $default = null): mixed
  {
    return $_GET[$key] ?? $default;
  }

  public function post(string $key, mixed $default = null): mixed
  {
    return $_POST[$key] ?? $default;
  }

  public function all(): array
  {
    return array_merge($_GET, $_POST);
  }

  public function has(string $key): bool
  {
    return isset($_POST[$key]) || isset($_GET[$key]);
  }
}
