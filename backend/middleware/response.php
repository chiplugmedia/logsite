<?php
declare(strict_types=1);

function json_input(): array
{
    $raw = file_get_contents('php://input');
    $decoded = json_decode($raw ?: '', true);

    if (is_array($decoded)) {
        return $decoded;
    }

    return $_POST;
}

function respond_json(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}

function require_method(string $method): void
{
    if ($_SERVER['REQUEST_METHOD'] !== strtoupper($method)) {
        respond_json(['status' => 'error', 'message' => 'Method not allowed'], 405);
    }
}

function filter_string_api(?string $value): string
{
    return htmlspecialchars(stripslashes(trim((string) $value)), ENT_QUOTES, 'UTF-8');
}
