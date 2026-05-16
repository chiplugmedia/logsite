<?php

$genMsg="";
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";


$reference = $_GET['reference'] ?? null;

if (!$reference) {
    exit("Invalid transaction reference.");
}

$paystack_secret_key = 'sk_live_eed0483303aef796c3702b93e6400902f9d2c0d8';
$verify_url = "https://api.paystack.co/transaction/verify/" . urlencode($reference);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $verify_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $paystack_secret_key",
    "Cache-Control: no-cache"
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result && isset($result['data']['status']) && $result['data']['status'] === 'success') {
    $data = $result['data'];
    $amount = $data['amount'] / 100; // ✅ Convert from kobo to naira
    $email = $data['customer']['email'];
    $reference = $data['reference'];
    $currency = $data['currency'] ?? 'NGN';

    $stmt = $link->prepare("SELECT username, funds FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $userResult = $stmt->get_result();

    if ($userResult->num_rows === 1) {
        $user = $userResult->fetch_assoc();
        $username = $user['username'];
        $funds = $user['funds'];

        $stmt = $link->prepare("SELECT * FROM fundwallet WHERE trxid = ?");
        $stmt->bind_param("s", $reference);
        $stmt->execute();
        $fundResult = $stmt->get_result();

        if ($fundResult->num_rows === 0) {
            $balanceBefore = $funds;
            $balanceAfter = $funds + $amount;
            $now = date("Y-m-d H:i:s");

            $stmt = $link->prepare("INSERT INTO fundwallet 
                (code, username, email, amount, channel, status, trxid, initiatedfrom, date, message, currency, balancebefore, balanceafter) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $channel = "Paystack";
            $status = "successful";
            $message = "Wallet funding successful";
            $stmt->bind_param("sssssssssssss", $reference, $username, $email, $amount, $channel, $status, $reference, $channel, $now, $message, $currency, $balanceBefore, $balanceAfter);
            $stmt->execute();

            $stmt = $link->prepare("UPDATE users SET funds = funds + ? WHERE username = ?");
            $stmt->bind_param("ds", $amount, $username);
            $stmt->execute();

            $genMsg = sendResponse("success", "Wallet funded successfully");
            echo "<script>setTimeout(() => location.href='$stream/dash/deposit.php', 3000);</script>";
        } else {
            $genMsg = sendResponse("error", "Transaction already exists");
        }
    } else {
        $genMsg = sendResponse("error", "User not found");
    }
} else {
    $genMsg = sendResponse("error", "Payment verification failed");
}

?>
