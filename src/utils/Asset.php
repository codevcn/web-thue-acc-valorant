<?php
function queryAssetWithVersion($path)
{
  $fullPath = $_SERVER['DOCUMENT_ROOT'] . $path;
  if (file_exists($fullPath)) {
    return $path . '?v=' . '1.0.0';
  }
  return $path; // fallback nếu file không tồn tại
}
