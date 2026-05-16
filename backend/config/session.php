<?php
declare(strict_types=1);

require_once __DIR__ . '/app.php';

function boot_api(): void
{
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    $allowedOrigins = array_filter(array_map('trim', explode(',', env_value('CORS_ALLOWED_ORIGINS', APP_FRONTEND_URL) ?? APP_FRONTEND_URL)));

    if ($origin !== '' && in_array($origin, $allowedOrigins, true)) {
        header("Access-Control-Allow-Origin: $origin");
        header('Vary: Origin');
    }

    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }

    if (session_status() !== PHP_SESSION_ACTIVE) {
        $secureCookie = filter_var(env_value('SESSION_SECURE', (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'true' : 'false'), FILTER_VALIDATE_BOOLEAN);
        $sameSite = env_value('SESSION_SAMESITE', 'Lax') ?? 'Lax';

        session_set_cookie_params([
            'lifetime' => 3600 * 24 * 2,
            'path' => '/',
            'httponly' => true,
            'samesite' => $sameSite,
            'secure' => $secureCookie,
        ]);
        session_start();
    }
}
