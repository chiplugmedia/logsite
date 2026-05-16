<?php
$genMsg="";


function generateTransactionID($length = 8) {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}

if (isset($_POST['pay'])) {

    if (!empty($_POST['amount']) && !empty($_POST['email'])) {

        // Sanitize inputs
        $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $email  = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $genMsg = sendResponse("error", "Please enter a valid email address");
        } else {

            $min_amount = 500;
            $max_amount = 5000000;

            if ($amount < $min_amount || $amount > $max_amount) {
                $genMsg = sendResponse(
                    "error",
                    "Deposit must be between " . number_format($min_amount) . " and " . number_format($max_amount)
                );
            } else {

                $cartid = generateTransactionID(10);
                $callback_url = "https://pinatexlogs.com/dash/actions/squad/process.php?cartid=$cartid";
                $secretKey = "sandbox_sk_4de25381409caab337272e426868607517a8bd40";

                // Prepare JSON payload
                $data = json_encode([
                    'amount' => $amount,
                    'email' => $email,
                     'key' => $secretKey,
                    'currency' => 'NGN',
                    'initiate_type' => 'inline',
                    'transaction_ref' => $cartid,
                    'callback_url' => $callback_url,
                ]);

                // Build shell cURL command
                $curlCmd = "curl -s -X POST 'https://sandbox-api.squadco.com/transaction/initiate' "
                   . "-H 'Authorization: Bearer 47M3DMZD' "
                    . "-H 'Content-Type: application/json' "
                    . "-d '$data'";

                // Execute command
                $response = shell_exec($curlCmd);

                $result = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $genMsg = sendResponse("error", "Invalid API response");
                } elseif (isset($result['status'], $result['data']['checkout_url']) && $result['status'] === 200) {
                    // Redirect to checkout modal
                    header("Location: " . $result['data']['checkout_url']);
                    exit;
                } else {
                    $message = $result['message'] ?? 'Unknown error';
                    $genMsg = sendResponse("error", "Payment initialization failed: $message");
                }
            }
        }

    } else {
        $genMsg = sendResponse("error", "Email and amount are required.");
    }
}


?>