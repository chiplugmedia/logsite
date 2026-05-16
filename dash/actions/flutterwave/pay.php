<?php
$genMsg="";

function generateTransactionID($length = 12) {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}


// Store secret key in configuration
define('FLW_SECRET_KEY', 'FLWSECK-55a60a61eb49ece8e1cc17521b597318-19b5d2f12f3vt-X');
define('SITE_URL', 'https://pinatexlogs.com');



if (isset($_POST['pay'])) {

    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);
    $email  = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$amount || !$email) {
        echo sendResponse("error", "Invalid amount or email");
    } else {

        if ($amount < 1000 || $amount > 500000) {
            echo sendResponse("error", "Deposit must be between ₦1,000 and ₦500,000");
        } else {

            $tx_ref = generateTransactionID();
            $callback = SITE_URL . "/dash/actions/flutterwave/process.php?transactionid={$tx_ref}";

            $reference = get_rand_alphanumeric(10);
            $currency = "NGN";
$status = "pending";
$gateWay = "FlutterWave";

// Save PENDING transaction
$stmt = $link->prepare("
    INSERT INTO fundwallet 
    (code, username, trxid, email, amount, currency, status, initiatedfrom, date)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
");
$stmt->bind_param("ssssdsss", $reference, $username, $tx_ref, $email, $amount, $currency, $status, $gateWay);
$stmt->execute();

            // Flutterwave payload
            $payload = [
                "tx_ref" => $tx_ref,
                "amount" => $amount,
                "currency" => "NGN",
                "redirect_url" => $callback,
                "payment_options" => "card,banktransfer,ussd",
                "customer" => [
                    "email" => $email
                ],
                "customizations" => [
                    "title" => "Wallet Funding",
                    "description" => "Deposit into wallet"
                ]
            ];

            $ch = curl_init("https://api.flutterwave.com/v3/payments");
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer " . FLW_SECRET_KEY,
                    "Content-Type: application/json"
                ]
            ]);

            $res = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (!empty($res['data']['link'])) {
                header("Location: " . $res['data']['link']);
            } else {
                echo sendResponse("error", "Payment initialization failed");
            }
        }
    }
}
?>