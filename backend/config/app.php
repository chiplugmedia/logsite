<?php
declare(strict_types=1);

const APP_TIMEZONE = 'Africa/Lagos';
const APP_SITE_LINK = 'https://pinatexlogs.com';
const APP_FRONTEND_URL = 'http://localhost:5174';

date_default_timezone_set(APP_TIMEZONE);

function load_env_file(string $path): void
{
    if (!is_readable($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, "\"'");

        if ($key !== '' && getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

load_env_file(dirname(__DIR__, 2) . '/.env');
load_env_file(dirname(__DIR__) . '/.env');

function env_value(string $key, ?string $fallback = null): ?string
{
    $value = getenv($key);
    return $value === false ? $fallback : $value;
}

function app_frontend_url(): string
{
    return rtrim(env_value('APP_FRONTEND_URL', APP_FRONTEND_URL) ?? APP_FRONTEND_URL, '/');
}
