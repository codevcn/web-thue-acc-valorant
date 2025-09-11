<?php
function queryAssetWithVersion($path)
{
  $fullPath = $_SERVER['DOCUMENT_ROOT'] . $path;
  if (file_exists($fullPath)) {
    return $path . '?v=' . filemtime($fullPath);
  }
  return $path; // fallback nếu file không tồn tại
}
