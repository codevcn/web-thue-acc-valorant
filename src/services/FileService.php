<?php

declare(strict_types=1);

namespace Services;

class FileService
{
  public function __construct() {}

  public function saveAvatarImage($file, int $accountId): array
  {
    $uploadDir = __DIR__ . '/../../public/images/account/';

    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Lấy thông tin file
    $fileInfo = pathinfo($file['name']);
    $extension = strtolower($fileInfo['extension']);

    // Kiểm tra định dạng file hợp lệ
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($extension, $allowedExtensions)) {
      throw new \InvalidArgumentException('Định dạng file không được hỗ trợ. Chỉ chấp nhận: JPG, PNG, WEBP.');
    }

    // Kiểm tra kích thước file (tối đa 5MB)
    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxSize) {
      throw new \InvalidArgumentException('Kích thước file quá lớn. Tối đa 5MB.');
    }

    // Tạo tên file mới
    $fileName = 'account_' . $accountId . '_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    $filePath = $uploadDir . $fileName;

    // Di chuyển file upload vào thư mục đích
    $result = move_uploaded_file($file['tmp_name'], $filePath);
    if (!$result) {
      throw new \RuntimeException('Không thể lưu file ảnh.');
    }

    return [
      'fileName' => $fileName,
      'filePath' => $filePath,
    ];
  }

  public function deleteAvatarImage(string $fileName): void
  {
    if (empty($fileName)) {
      return;
    }

    $filePath = __DIR__ . '/../../public/images/account/' . $fileName;

    if (file_exists($filePath)) {
      unlink($filePath);
    }
  }
}
