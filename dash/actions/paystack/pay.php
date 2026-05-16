<?php
$genMsg="";


function generateTransactionID($length = 8) {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}

if (isset($_POST['pay'])) {
    if (!empty($_POST['amount']) && !empty($_POST['email'])) {
        $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $genMsg = sendResponse("error", "Please enter a valid email address");
        } else {
            $min_amount = 1000;
            $max_amount = 5000000;

            if ($amount < $min_amount || $amount > $max_amount) {
                $genMsg = sendResponse("error", "Minimum Deposit is " . number_format($min_amount));
            } else {
                $cartid = generateTransactionID(10);
                $callback_url = "https://pinatexlogs.com/dash/actions/paystack/process.php?cartid=$cartid";

                $fields = [
                    'email' => $email,
                    'amount' => $amount * 100, // in kobo
                    'callback_url' => $callback_url,
                    'metadata' => [
                        'cartid' => $cartid,
                        'cancel_action' => "https://pinatexlogs.com/dash/deposit.php"
                    ]
                ];

                $ch = curl_init("https://api.paystack.co/transaction/initialize");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Authorization: Bearer sk_test_3a35f937cbad6686d369a97ba7e3086c1e30f4e3",
                    "Content-Type: application/json",
                ]);
                curl_setopt($ch, CURLOPT_POST, true);

                $response = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);

                if ($err) {
                    $genMsg = sendResponse("error", "Curl Error: $err");
                } else {
                    $result = json_decode($response, true);
                    if (isset($result['status']) && $result['status'] === true && isset($result['data']['authorization_url'])) {
                        header("Location: " . $result['data']['authorization_url']);
                        exit;
                    } else {
                        $genMsg = sendResponse("error", "Payment initialization failed: " . ($result['message'] ?? 'Unknown error'));
                    }
                }
            }
        }
    } else {
        $genMsg = "Error: Email and amount are required.";
    }
}

?>