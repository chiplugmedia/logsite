<?php
// session_start();
// include('../../includes/db_connect.php'); // ✅ Make sure $link is defined here

$genMsg = "";

$secretKey = 'ECRS-LIVE-SKlSas35Ktstwok5U8mGqzv4TIF48Q0aQuFfvT8PG2';
$baseUrl = 'https://api.ercaspay.com/api/v1';
// ============================
// Generate Transaction ID
// ============================
function generateTransactionID() {
    // Random alphanumeric part (12 characters)
    $alphaNum = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);

    // Random numeric part (10 digits)
    $numeric = substr(str_shuffle('0123456789'), 0, 10);

    // Combine with TXN prefix
    return "TXN-{$alphaNum}-{$numeric}";
}

// ========== PAYMENT INITIALIZATION ==========
if (isset($_POST['pay'])) {

    if (!empty($_POST['amount']) && !empty($_POST['email'])) {

        $amount   = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $username = $_SESSION['username'] ?? 'guest';

        $min_amount = 500;
        $max_amount = 500000;

        if ($amount < $min_amount || $amount > $max_amount) {
            $genMsg = sendResponse("error", "Minimum deposit is ₦" . number_format($min_amount));
        } else {

            // ✅ Generate unique transaction ID
            $txnID = generateTransactionID();

            // Fetch user details from DB
            $stmtUser = $link->prepare("SELECT fullname, phone FROM users WHERE username=? LIMIT 1");
            $stmtUser->bind_param("s", $username);
            $stmtUser->execute();
            $stmtUser->bind_result($fullname, $phoneNumber);
            $stmtUser->fetch();
            $stmtUser->close();

            $redirectUrl = "https://pinatexlogs.com/dash/actions/nomba/process.php";

            $postData = array(
                "amount" => $amount,
                "paymentReference" => $txnID,
                "paymentMethods" => "card,bank-transfer,ussd,qrcode",
                "customerName" => $fullname,
                "customerEmail" => $email,
                "customerPhoneNumber" => $phoneNumber,
                "redirectUrl" => $redirectUrl,
                "description" => "Wallet Funding",
                "currency" => "NGN",
                "feeBearer" => "customer",
                "metadata" => array(
                    "firstname" => $fullname,
                    "lastname" => $username,
                    "email" => $email
                )
            );

            // Send request to WKPlus
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$baseUrl/payment/initiate",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($postData),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    "Authorization: Bearer $secretKey"
                ),
            ));

            $response = curl_exec($curl);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($http_status == 200) {
                $result = json_decode($response, true);

                if (($result['responseCode'] ?? '') === 'success') {
                    $checkoutUrl = $result['responseBody']['checkoutUrl'] ?? null;
$transactionReference = $result['responseBody']['transactionReference'] ?? null;
                    // ✅ Prepare insert values
                    $code = bin2hex(random_bytes(8)); 
                    $channel = 'Ercaspay';
                    $status = 'pending';
                    $initiatedfrom = 'bankTransfer';
                    $message = 'Transaction is pending';
                    $currency = 'NGN';
                    $balanceBefore = 0;
                    $balanceAfter = 0;
                    $date = date('Y-m-d H:i:s');

                    $stmt = $link->prepare("INSERT INTO fundwallet 
                        (code, username, email, amount, channel, status, trxid, initiatedfrom, message, currency,responseCode, balancebefore, balanceafter, date)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?)");

                    $stmt->bind_param(
                        "ssssssssssssss", 
                        $code, $username, $email, $amount, $channel, $status, $txnID, 
                        $initiatedfrom, $message, $currency, $transactionReference, $balanceBefore, $balanceAfter, $date
                    );

                    $stmt->execute();
                    $stmt->close();

                    if ($checkoutUrl) {
                        header("Location: $checkoutUrl");
                        exit;
                    } else {
                        $genMsg = sendResponse("error", "Payment link not available");
                    }
                } else {
                    $genMsg = sendResponse("error", $result['responseMessage'] ?? 'Payment initiation failed');
                }
            } else {
                $genMsg = sendResponse("error", "Failed to connect to payment gateway");
            }
        }

    } else {
        $genMsg = sendResponse("error", "All fields are required.");
    }
}

?>
