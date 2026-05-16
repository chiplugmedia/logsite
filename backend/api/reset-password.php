<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../middleware/response.php';
require_once __DIR__ . '/../auth/auth_service.php';

boot_api();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = (string) ($_GET['token'] ?? $_GET['tkn'] ?? '');
    $email = reset_token_email($token);

    if (!$email) {
        respond_json(['status' => 'error', 'message' => 'Invalid password reset link'], 404);
    }

    $_SESSION['forgotEmail'] = $email;
    respond_json(['status' => 'success', 'email' => $email]);
}

require_method('POST');

$response = reset_password_with_token(json_input());
$code = $response['code'];
unset($response['code']);

respond_json($response, $code);
