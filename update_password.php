<?php

declare(strict_types=1);

$db = new PDO('sqlite:' . __DIR__ . '/database/app.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$password = password_hash('123456', PASSWORD_DEFAULT);
$stmt = $db->prepare("UPDATE users SET [password] = ?");
$stmt->execute([$password]);
