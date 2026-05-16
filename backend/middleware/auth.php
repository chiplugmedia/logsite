<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/response.php';

function current_user(): ?array
{
    if (empty($_SESSION['username'])) {
        return null;
    }

    $username = filter_string_api((string) $_SESSION['username']);
    $sql = db()->prepare('SELECT fullname, username, email, phone, role, status, image, funds, referralfunds, vtubalance, score FROM users WHERE username=? LIMIT 1');
    $sql->bind_param('s', $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows !== 1) {
        return null;
    }

    return $result->fetch_assoc();
}

function require_auth(array $roles = []): array
{
    $user = current_user();

    if (!$user) {
        respond_json(['status' => 'error', 'message' => 'Authentication required'], 401);
    }

    if ($roles !== [] && !in_array($user['role'], $roles, true)) {
        respond_json(['status' => 'error', 'message' => 'You are not authorized to access this resource'], 403);
    }

    return $user;
}
