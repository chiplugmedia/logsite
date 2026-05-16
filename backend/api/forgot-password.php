<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../middleware/response.php';
require_once __DIR__ . '/../auth/auth_service.php';

boot_api();
require_method('POST');

$response = forgot_password(json_input());
$code = $response['code'];
unset($response['code']);

respond_json($response, $code);
