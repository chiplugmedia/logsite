<?php

$genMsg="";
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

// Configuration
$secretKey = 'ECRS-LIVE-SKlSas35Ktstwok5U8mGqzv4TIF48Q0aQuFfvT8PG2';
$baseUrl = 'https://api.ercaspay.com/api/v1';

// ----------------------------
// VERIFY TRANSACTION FUNCTION
// ----------------------------
function verifyTransaction($transactionRef, $baseUrl, $secretKey) {
    if (empty($transactionRef)) return false;
 
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUrl . "/payment/transaction/verify/" . urlencode($transactionRef),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $secretKey
        ],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $response = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($curl);

    if ($response === false) {
        error_log("CURL Error: " . $curl_error);
        curl_close($curl);
        return false;
    }

    curl_close($curl);

    if ($http_status !== 200) {
        error_log("API Error: HTTP $http_status - " . $response);
        return false;
    }

    return json_decode($response, true);
}

// ----------------------------
// PROCESS VERIFIED TRANSACTION
// ----------------------------
if (($verifyData['responseCode'] ?? '') === 'success') {

    $responseBody   = $verifyData['responseBody'] ?? [];
    $verifiedStatus = strtolower($responseBody['status'] ?? '');
    $actualMoney    = floatval($responseBody['amount'] ?? 0);
    $ercs_reference = $responseBody['ercs_reference'] ?? '';
    $tx_reference   = $responseBody['tx_reference'] ?? '';
    $customerEmail  = $responseBody['customer']['email'] ?? '';
    $currency       = $responseBody['currency'] ?? '';
    $channel        = $responseBody['channel'] ?? '';
    $message        = $verifyData['responseMessage'] ?? '';

    if ($verifiedStatus === 'successful') {

        // Check if transaction exists
        $stmt = $link->prepare("SELECT * FROM fundwallet WHERE responseCode = ?");
        $stmt->bind_param("s", $ercs_reference);
        $stmt->execute();
        $transaction = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$transaction) {
            $genMsg = sendResponse("error", "Transaction not found: " . $ercs_reference);
        } else {
            // Validate critical data
            if (empty($customerEmail) || $actualMoney <= 0 || strtoupper($currency) !== 'NGN') {
                $genMsg = sendResponse("error", "Invalid transaction data received");
            } else {
                // Begin DB transaction
                $link->begin_transaction();
                try {
                    // Fetch user
                    $sql = $link->prepare("SELECT username, funds FROM users WHERE email = ? FOR UPDATE");
                    $sql->bind_param("s", $customerEmail);
                    $sql->execute();
                    $result = $sql->get_result();

                    if ($result->num_rows !== 1) {
                        throw new Exception("User not found");
                    }

                    $row = $result->fetch_assoc();
                    $username = $row["username"];
                    $balanceBefore = floatval($row["funds"]);
                    $balanceAfter = $balanceBefore + $actualMoney;

                    // ----------------------------
                    // UPDATE EXISTING TRANSACTION
                    // ----------------------------
                    $updateTransactionSql = $link->prepare("
                        UPDATE fundwallet
                        SET 
                            username = ?, 
                            email = ?, 
                            amount = ?, 
                            channel = ?, 
                            status = ?, 
                            initiatedfrom = ?, 
                            date = ?, 
                            message = ?, 
                            currency = ?, 
                            balancebefore = ?, 
                            balanceafter = ?
                        WHERE trxid = ?
                    ");

                    $gateway = "Ercaspay";

                    $updateTransactionSql->bind_param(
                        "ssdssssssdds",
                        $username,
                        $customerEmail,
                        $actualMoney,
                        $channel,
                        $verifiedStatus,
                        $gateway,
                        $dateTime,
                        $message,
                        $currency,
                        $balanceBefore,
                        $balanceAfter,
                        $ercs_reference
                    );

                    if (!$updateTransactionSql->execute()) {
                        throw new Exception("Failed to update transaction");
                    }

                    // Update wallet
                    $updateWalletSql = $link->prepare("UPDATE users SET funds = funds + ? WHERE username = ?");
                    $updateWalletSql->bind_param("ds", $actualMoney, $username);

                    if (!$updateWalletSql->execute()) {
                        throw new Exception("Wallet update failed");
                    }

                    // Commit transaction
                    $link->commit();

                    $genMsg = sendResponse("success", "Wallet funded successfully");

                    echo "<script>
                        setTimeout(function () {
                            window.location.href = '$stream/dash/deposit.php';
                        }, 3000);
                    </script>";

                } catch (Exception $e) {
                    $link->rollback();
                    $genMsg = sendResponse("error", $e->getMessage());
                }
            }
        }

    } else {
        $genMsg = sendResponse("error", "Transaction status: " . strtoupper($verifiedStatus));
    }

} else {
    $genMsg = sendResponse("error", "Transaction verification failed or invalid response");
}

?>
