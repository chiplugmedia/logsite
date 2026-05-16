<?php

$genMsg="";
//require $_SERVER['DOCUMENT_ROOT']."/stream.php";
//require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
//require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";



// Check if the 'event' is 'charge.success'
if ($data['event'] === 'charge.success') {
    // Extract the necessary information from the webhook data
    $reference = $data['data']['reference'];
    $currency = $data['data']['currency'];
    $amount = $data['data']['amount'];
    $fee = $data['data']['fee'];
    $payment_reference = $data['data']['payment_reference'];
    $transaction_status = $data['data']['transaction_status'];
    
    // Access metadata if needed
    $metadata = $data['data']['metadata'];
    $internalRef = $metadata['internalRef'];
    $age = $metadata['age'];
    $fixed = $metadata['fixed'];
    
    // Process the payment here, for example, updating the database with the transaction status
    if ($transaction_status === 'success') {
        // Check if the user exists
        $stmt = $link->prepare("SELECT username, funds FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $userResult = $stmt->get_result();

        if ($userResult->num_rows === 1) {
            $user = $userResult->fetch_assoc();
            $username = $user['username'];
            $funds = $user['funds'];

            // Check if the transaction already exists
            $stmt = $link->prepare("SELECT * FROM fundwallet WHERE trxid = ?");
            $stmt->bind_param("s", $reference);
            $stmt->execute();
            $fundResult = $stmt->get_result();

            if ($fundResult->num_rows === 0) {
                // Process the transaction
                $balanceBefore = $funds;
                $balanceAfter = $balanceBefore + $amount;
                $dateTime = date("Y-m-d H:i:s");
                $paymentType = "Korapay";
                $status = "success";  // Set status for wallet entry
                $message = "Wallet funding successful";

                // Insert transaction into `fundwallet`
                $stmt = $link->prepare("INSERT INTO fundwallet (code, username, email, amount, channel, status, trxid, initiatedfrom, date, message, currency, balancebefore, balanceafter) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssssssss", $reference, $username, $email, $amount, $paymentType, $status, $reference, 'Korapay', $dateTime, $message, $currency, $balanceBefore, $balanceAfter);
                $stmt->execute();

                // Update user's balance
                $stmt = $link->prepare("UPDATE users SET funds = funds + ? WHERE username = ?");
                $stmt->bind_param("ds", $amount, $username);
                $stmt->execute();

                // Commit transaction
                $link->commit();

                // Set success message
                $status = "success";
                $message = "Wallet funded successfully";
                $genMsg = sendResponse($status, $message);
                echo "<script>setTimeout(() => location.href='$stream/dash/deposit.php', 3000);</script>";
            } else {
                // Transaction already processed
                $status = "error";
                $message = "Transaction already exists";
                $genMsg = sendResponse($status, $message);
            }
        } else {
            // User not found
            $status = "error";
            $message = "User not found";
            $genMsg = sendResponse($status, $message);
        }
    } else {
        // Invalid event or failed transaction
        $status = "error";
        $message = "Unhandled event or failed transaction";
        $genMsg = sendResponse($status, $message);
    }
} else {
    // Invalid event type
    $status = "error";
    $message = "Unhandled event";
    $genMsg = sendResponse($status, $message);
}
?>
