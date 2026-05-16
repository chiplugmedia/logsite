<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../middleware/auth.php';

boot_api();
require_method('GET');

$user = require_auth(['user', 'vendor', 'agent']);
$username = $user['username'];
$link = db();

function scalar_value(mysqli $link, string $query, string $username, string $type = 's'): mixed
{
    $statement = $link->prepare($query);
    $statement->bind_param($type, $username);
    $statement->execute();
    $row = $statement->get_result()->fetch_assoc();

    return $row ? array_values($row)[0] : null;
}

function recent_rows(mysqli $link, string $query, string $username, int $limit = 5): array
{
    $statement = $link->prepare($query);
    $statement->bind_param('si', $username, $limit);
    $statement->execute();
    $result = $statement->get_result();
    $rows = [];

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;
}

$totalReferrals = (int) scalar_value($link, 'SELECT COUNT(*) FROM referrals WHERE referral=?', $username);
$totalTransactions = (int) scalar_value($link, 'SELECT COUNT(*) FROM transactions WHERE username=?', $username);
$totalOrders = (int) scalar_value($link, 'SELECT COUNT(*) FROM userpurchases WHERE username=?', $username);
$totalFunded = (float) (scalar_value($link, "SELECT COALESCE(SUM(amount), 0) FROM fundwallet WHERE username=? AND status='successful'", $username) ?? 0);
$totalCompletedPurchases = (float) (scalar_value($link, "SELECT COALESCE(SUM(amount), 0) FROM userpurchases WHERE username=? AND status='Completed'", $username) ?? 0);
$totalWithdrawn = (float) (scalar_value($link, "SELECT COALESCE(SUM(amount), 0) FROM withdrawals WHERE username=? AND (status='success' OR status='successful')", $username) ?? 0);
$referralUsername = (string) (scalar_value($link, 'SELECT COALESCE(referral, "") FROM referrals WHERE username=? LIMIT 1', $username) ?? '');

$bankStatement = $link->prepare('SELECT bankname, acctname, acctnum, bankcode FROM bankaccounts WHERE username=? LIMIT 1');
$bankStatement->bind_param('s', $username);
$bankStatement->execute();
$bank = $bankStatement->get_result()->fetch_assoc();

$recentOrders = recent_rows(
    $link,
    'SELECT title, amount, status, reference, date FROM userpurchases WHERE username=? ORDER BY id DESC LIMIT ?',
    $username
);

$recentFunding = recent_rows(
    $link,
    'SELECT amount, status, trxid, date, message FROM fundwallet WHERE username=? ORDER BY id DESC LIMIT ?',
    $username
);

respond_json([
    'status' => 'success',
    'user' => public_user_payload($user),
    'balances' => [
        'main' => (float) ($user['funds'] ?? 0),
        'referral' => (float) ($user['referralfunds'] ?? 0),
        'vtu' => (float) ($user['vtubalance'] ?? 0),
        'score' => (float) ($user['score'] ?? 0),
    ],
    'stats' => [
        'totalReferrals' => $totalReferrals,
        'totalTransactions' => $totalTransactions,
        'totalOrders' => $totalOrders,
        'totalFunded' => $totalFunded,
        'totalCompletedPurchases' => $totalCompletedPurchases,
        'totalWithdrawn' => $totalWithdrawn,
    ],
    'bank' => $bank ?: null,
    'referralUsername' => $referralUsername,
    'recentOrders' => $recentOrders,
    'recentFunding' => $recentFunding,
]);
