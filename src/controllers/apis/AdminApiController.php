<?php

declare(strict_types=1);

namespace Controllers\Apis;

use Services\RulesService;
use Services\UserService;

class AdminApiController
{
  private $userService;
  private $rulesService;

  public function __construct(UserService $userService, RulesService $rulesService)
  {
    $this->userService = $userService;
    $this->rulesService = $rulesService;
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

    if (isset($_POST['rulesData'])) {
      $rulesData = $_POST['rulesData'];
      try {
        $this->rulesService->updateRules($rulesData);
      } catch (\Throwable $th) {
        http_response_code(500);
        return [
          'success' => false,
          'message' => 'Đã xảy ra lỗi khi cập nhật quy định thuê acc'
        ];
      }
    }

    return [
      'success' => true,
    ];
  }
}
