<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../middleware/auth.php';

boot_api();
require_method('GET');

$user = current_user();

respond_json([
    'authenticated' => $user !== null,
    'user' => $user,
]);
