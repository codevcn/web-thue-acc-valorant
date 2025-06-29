<?php

declare(strict_types=1);

namespace Controllers\Apis;

use Services\UserService;

class AdminApiController
{
  private $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function updateAdmin(): array
  {
    if (!isset($_POST['adminData'])) {
      http_response_code(400);
      return [
        'success' => false,
        'message' => 'Thiếu dữ liệu admin'
      ];
    }

    // Lấy dữ liệu admin (giả sử client stringify JSON và append vào formData)
    $adminJson = $_POST['adminData'];
    $adminData = json_decode($adminJson, true);

    if (!is_array($adminData)) {
      http_response_code(400);
      return [
        'success' => false,
        'message' => 'Dữ liệu admin không hợp lệ'
      ];
    }

    try {
      $this->userService->updateAdmin($adminData);
    } catch (\Throwable $th) {
      if ($th instanceof \InvalidArgumentException) {
        http_response_code(400);
        return [
          'success' => false,
          'message' => $th->getMessage()
        ];
      }

      http_response_code(500);
      return [
        'success' => false,
        'message' => 'Lỗi hệ thống'
      ];
    }

    return [
      'success' => true,
    ];
  }
}
