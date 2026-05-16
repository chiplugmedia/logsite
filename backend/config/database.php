<?php
declare(strict_types=1);

require_once __DIR__ . '/app.php';

function legacy_db_config(): array
{
    $connPath = dirname(__DIR__, 2) . '/includes/conn.php';
    if (!is_readable($connPath)) {
        return [];
    }

    $contents = file_get_contents($connPath);
    if (!is_string($contents)) {
        return [];
    }

    $pattern = '/new\s+mysqli\s*\(\s*["\']([^"\']+)["\']\s*,\s*["\']([^"\']+)["\']\s*,\s*["\']([^"\']*)["\']\s*,\s*["\']([^"\']+)["\']\s*\)/';
    if (preg_match($pattern, $contents, $matches) !== 1) {
        return [];
    }

    return [
        'host' => $matches[1],
        'user' => $matches[2],
        'password' => $matches[3],
        'name' => $matches[4],
    ];
}

function db(): mysqli
{
    static $link = null;

    if ($link instanceof mysqli) {
        return $link;
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $legacy = legacy_db_config();

    $link = new mysqli(
        env_value('DB_HOST', $legacy['host'] ?? 'localhost'),
        env_value('DB_USER', $legacy['user'] ?? ''),
        env_value('DB_PASSWORD', $legacy['password'] ?? ''),
        env_value('DB_NAME', $legacy['name'] ?? '')
    );
    $link->set_charset('utf8mb4');

    return $link;
}
