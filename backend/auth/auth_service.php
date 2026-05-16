<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/mail.php';
require_once __DIR__ . '/../middleware/response.php';

function legacy_password_hash(string $password): string
{
    return password_hash(sha1($password), PASSWORD_DEFAULT);
}

function verify_legacy_password(string $password, string $storedHash): bool
{
    return password_verify(sha1($password), $storedHash);
}

function role_redirect(string $role): string
{
    return match ($role) {
        'admin' => '/admin/dashboard.php',
        'assistant' => '/assistant/account.php',
        'user', 'agent', 'vendor' => '/dash',
        default => '/login',
    };
}

function public_user_payload(array $row): array
{
    return [
        'fullname' => $row['fullname'] ?? '',
        'username' => $row['username'] ?? '',
        'email' => $row['email'] ?? '',
        'phone' => $row['phone'] ?? '',
        'role' => $row['role'] ?? '',
        'status' => $row['status'] ?? '',
        'image' => $row['image'] ?? '',
    ];
}

function find_user_by_login(string $usernameOrEmail): ?array
{
    $sql = db()->prepare('SELECT * FROM users WHERE username=? OR email=? LIMIT 1');
    $sql->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
    $sql->execute();
    $result = $sql->get_result();

    return $result->num_rows === 1 ? $result->fetch_assoc() : null;
}

function login_user(array $input): array
{
    $username = filter_string_api($input['username'] ?? '');
    $password = (string) ($input['password'] ?? '');

    if ($username === '') {
        return ['status' => 'error', 'message' => 'Enter your username', 'code' => 422];
    }

    if ($password === '') {
        return ['status' => 'error', 'message' => 'Enter your password', 'code' => 422];
    }

    $row = find_user_by_login($username);

    if (!$row || !verify_legacy_password($password, $row['password'])) {
        return ['status' => 'error', 'message' => 'Incorrect username or password', 'code' => 401];
    }

    if (($row['status'] ?? '') === 'suspended' && !in_array($row['role'], ['user', 'vendor'], true)) {
        return ['status' => 'error', 'message' => 'Your account has been suspended', 'code' => 403];
    }

    session_regenerate_id(true);
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];

    return [
        'status' => 'success',
        'message' => 'Login successful!',
        'user' => public_user_payload($row),
        'redirect' => role_redirect($row['role']),
        'code' => 200,
    ];
}

function field_exists(string $field, string $value): bool
{
    $allowed = ['username', 'email', 'phone'];
    if (!in_array($field, $allowed, true)) {
        throw new InvalidArgumentException('Invalid lookup field');
    }

    $sql = db()->prepare("SELECT 1 FROM users WHERE $field=? LIMIT 1");
    $sql->bind_param('s', $value);
    $sql->execute();

    return $sql->get_result()->num_rows > 0;
}

function signup_user(array $input): array
{
    $fullname = filter_string_api($input['fullname'] ?? '');
    $username = filter_string_api($input['username'] ?? '');
    $email = filter_string_api($input['email'] ?? '');
    $phoneNumber = filter_string_api($input['phoneNumber'] ?? '');
    $password = (string) ($input['password'] ?? '');
    $refUsername = filter_string_api($input['refUsername'] ?? '');

    if ($fullname === '') {
        return ['status' => 'error', 'message' => 'Enter your fullname', 'code' => 422];
    }
    if ($username === '') {
        return ['status' => 'error', 'message' => 'Enter a username', 'code' => 422];
    }
    if (strlen($username) > 20) {
        return ['status' => 'error', 'message' => 'Username should be less than 20 characters', 'code' => 422];
    }
    if ($email === '') {
        return ['status' => 'error', 'message' => 'Enter your email address', 'code' => 422];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['status' => 'error', 'message' => 'Enter a valid email address', 'code' => 422];
    }
    if ($phoneNumber === '') {
        return ['status' => 'error', 'message' => 'Enter your phone number', 'code' => 422];
    }
    if ($password === '') {
        return ['status' => 'error', 'message' => 'Enter a password', 'code' => 422];
    }
    if (strlen($password) < 8) {
        return ['status' => 'error', 'message' => 'Password must be at least 8 characters', 'code' => 422];
    }
    if (field_exists('username', $username)) {
        return ['status' => 'error', 'message' => 'Username already exists', 'code' => 409];
    }
    if (field_exists('email', $email)) {
        return ['status' => 'error', 'message' => 'Email already exists', 'code' => 409];
    }
    if (field_exists('phone', $phoneNumber)) {
        return ['status' => 'error', 'message' => 'Phone number already in use', 'code' => 409];
    }

    $hashedPassword = legacy_password_hash($password);
    $dateTime = date('d-m-Y H:i:s');
    $time = (string) time();
    $link = db();

    $link->begin_transaction();
    try {
        $sql = $link->prepare('INSERT INTO referrals (username, referral, date) VALUES (?, ?, ?)');
        $sql->bind_param('sss', $username, $refUsername, $dateTime);
        $sql->execute();

        $sql = $link->prepare('INSERT INTO users (fullname, username, email, phone, password, date, time) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $sql->bind_param('sssssss', $fullname, $username, $email, $phoneNumber, $hashedPassword, $dateTime, $time);
        $sql->execute();
        $link->commit();
    } catch (Throwable $exception) {
        $link->rollback();
        return ['status' => 'error', 'message' => 'Something went wrong creating account', 'code' => 500];
    }

    send_app_mail($email, $fullname, 'Welcome to Pinatexlogs', welcome_mail_body($fullname));

    return ['status' => 'success', 'message' => 'Registration successful', 'redirect' => '/login', 'code' => 201];
}

function random_token(int $length = 20): string
{
    return substr(bin2hex(random_bytes(max(10, (int) ceil($length / 2)))), 0, $length);
}

function forgot_password(array $input): array
{
    $email = filter_string_api($input['email'] ?? '');

    if ($email === '') {
        return ['status' => 'error', 'message' => 'Enter your email address', 'code' => 422];
    }

    $sql = db()->prepare('SELECT fullname, email FROM users WHERE email=? LIMIT 1');
    $sql->bind_param('s', $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows !== 1) {
        return ['status' => 'error', 'message' => 'Invalid email address', 'code' => 404];
    }

    $row = $result->fetch_assoc();
    $token = random_token(20);
    $dateTime = date('d-m-Y H:i:s');
    $link = db();

    $delete = $link->prepare('DELETE FROM otp WHERE email=?');
    $delete->bind_param('s', $email);

    if (!$delete->execute()) {
        return ['status' => 'error', 'message' => 'Something went wrong', 'code' => 500];
    }

    $insert = $link->prepare('INSERT INTO otp(email, otp, date) VALUES(?,?,?)');
    $insert->bind_param('sss', $email, $token, $dateTime);
    $insert->execute();

    $mail = send_app_mail($email, $row['fullname'], 'Password Reset', forgot_password_mail_body($row['fullname'], $token));

    if ($mail['status'] !== 'success') {
        return ['status' => 'error', 'message' => 'Something went wrong resetting the password, please try again', 'code' => 500];
    }

    return [
        'status' => 'success',
        'message' => 'Password reset link sent successfully. Please check your email and follow the procedures',
        'code' => 200,
    ];
}

function reset_token_email(string $token): ?string
{
    $token = filter_string_api($token);

    if ($token === '') {
        return null;
    }

    $sql = db()->prepare('SELECT email FROM otp WHERE otp=? LIMIT 1');
    $sql->bind_param('s', $token);
    $sql->execute();
    $result = $sql->get_result();

    return $result->num_rows === 1 ? $result->fetch_assoc()['email'] : null;
}

function reset_password_with_token(array $input): array
{
    $token = filter_string_api($input['token'] ?? $input['tkn'] ?? '');
    $password = (string) ($input['password'] ?? '');
    $confirmPsw = (string) ($input['confirmPsw'] ?? '');
    $email = reset_token_email($token);

    if (!$email) {
        return ['status' => 'error', 'message' => 'Invalid password reset link', 'code' => 404];
    }
    if ($password === '') {
        return ['status' => 'error', 'message' => 'Enter your new password', 'code' => 422];
    }
    if (strlen($password) < 8) {
        return ['status' => 'error', 'message' => 'Password must be at least 8 characters', 'code' => 422];
    }
    if ($confirmPsw === '') {
        return ['status' => 'error', 'message' => 'Retype your new password', 'code' => 422];
    }
    if ($password !== $confirmPsw) {
        return ['status' => 'error', 'message' => 'Passwords do not match', 'code' => 422];
    }

    $hashedPassword = legacy_password_hash($password);
    $link = db();
    $sql = $link->prepare('UPDATE users SET password=? WHERE email=?');
    $sql->bind_param('ss', $hashedPassword, $email);

    if (!$sql->execute()) {
        return ['status' => 'error', 'message' => 'Failed to update the password', 'code' => 500];
    }

    $delete = $link->prepare('DELETE FROM otp WHERE email=?');
    $delete->bind_param('s', $email);
    $delete->execute();

    return ['status' => 'success', 'message' => 'Password updated successfully', 'redirect' => '/login', 'code' => 200];
}
