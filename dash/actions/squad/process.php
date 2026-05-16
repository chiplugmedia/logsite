<?php


require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

$genMsg="";



$reference = $_GET['ref'] ?? null;

if ($reference) {
    // ✅ Correct secret key and API endpoint
    $squadco_secret_key = 'sandbox_sk_94f2b798466408ef4d19e848ee1a4d1a3e93f104046f';
    $verify_url = "https://sandbox-api.squadco.com/transaction/verify/" . urlencode($reference);

    // ✅ Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $verify_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $squadco_secret_key",
        "Cache-Control: no-cache"
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        $genMsg = sendResponse("error", "cURL Error: $err");
        exit;
    }

    $result = json_decode($response, true);

    // ✅ Check response status
    if ($result && isset($result['data']['status']) && $result['data']['status'] === 'success') {
        $data        = $result['data'];
        $amountNGN   = $data['amount'] ?? 0; 
        $email       = $data['customer']['email'] ?? '';
        $reference   = $data['transaction_ref'] ?? $reference;
        $currency    = $data['currency'] ?? 'NGN';

        // ✅ Convert NGN → USD (1 USD = 1000 NGN)
        $amountUSD = $amountNGN / 1000;

        // ✅ Fetch user
        $stmt = $link->prepare("SELECT username, funds FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $userResult = $stmt->get_result();

        if ($userResult->num_rows === 1) {
            $user     = $userResult->fetch_assoc();
            $username = $user['username'];
            $funds    = $user['funds'];

            // ✅ Check for duplicate transaction
            $stmt = $link->prepare("SELECT trxid FROM fundwallet WHERE trxid = ?");
            $stmt->bind_param("s", $reference);
            $stmt->execute();
            $fundResult = $stmt->get_result();

            if ($fundResult->num_rows === 0) {
                $balanceBefore = $funds;
                $balanceAfter  = $funds + $amountUSD;
                $now = date("Y-m-d H:i:s");

                // ✅ Insert funding record
                $stmt = $link->prepare("INSERT INTO fundwallet 
                    (code, username, email, amount, channel, status, trxid, initiatedfrom, date, message, currency, balancebefore, balanceafter) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $channel = "Squad";
                $status  = "successful";
                $message = "Wallet funding successful";
                $stmt->bind_param(
                    "sssssssssssss",
                    $reference,
                    $username,
                    $email,
                    $amountUSD,
                    $channel,
                    $status,
                    $reference,
                    $channel,
                    $now,
                    $message,
                    $currency,
                    $balanceBefore,
                    $balanceAfter
                );
                $stmt->execute();

                // ✅ Update user balance
                $stmt = $link->prepare("UPDATE users SET funds = funds + ? WHERE username = ?");
                $stmt->bind_param("ds", $amountUSD, $username);
                $stmt->execute();

                $genMsg = sendResponse("success", "Wallet funded successfully (₦" . number_format($amountNGN) . ")");
                echo "<script>setTimeout(() => location.href='https://elevategrowth.top/dash/auto_deposit.php', 3000);</script>";
            } else {
                $genMsg = sendResponse("error", "Transaction already exists");
            }
        } else {
            $genMsg = sendResponse("error", "User not found");
        }
    } else {
        $genMsg = sendResponse("error", "Payment verification failed or not successful");
    }
} else {
    $genMsg = sendResponse("error", "Missing transaction reference");
}



?>