<?php 
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/verifytransactions.php";



// Function to generate random alphanumeric string
function generateTransactionID($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Transaction fee and payment constraints
$transaction_fee = 5 / 100; // 5%
$minimal_payment = 500;
$maximal_payment = 1000000;

if (isset($_POST['fundWallet']) && !empty($_POST['fundWallet'])) {
    $status = "error";
    $message = "Enter the amount you transferred"; // Corrected typo
    $genMsg = sendResponse($status, $message);

    // Sanitize and retrieve necessary POST data
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);
    $transactionid = generateTransactionID(12); // Generate a transaction ID
    
    // Example usage of $channel variable, assumed to be defined elsewhere
    $channel = isset($_POST['channel']) ? $_POST['channel'] : '';

    // Process based on $channel type
    if ($channel == "webhook") {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $sql = $link->prepare("SELECT * FROM users WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $vtubalance = $row['vtubalance'];
        } else {
            $username = $vtubalance = "";
        }
    }

    // Check for required parameters
    if (empty($amount) || empty($username) || empty($status) || empty($transactionid)) {
        $status = "error";
        $message = "Missing Params";
        echo json_encode(array("status" => $status, "message" => $message));
        exit;
    }

    // Verify transaction using external function (assuming verifyFlutterWaveTransaction exists)
    $verifyTrx = verifyFlutterWaveTransaction($transactionid);
    $verifyTrx = json_decode($verifyTrx, true);
    $status = $verifyTrx['data']['status'];
    $message = $verifyTrx['message'];
    $amt = $verifyTrx['data']['amount'];
    $payment_type = $verifyTrx['data']['payment_type'];
    $curr = $verifyTrx['data']['currency'];
    $balanceBefore = $vtubalance;
    $balanceAfter = $balanceBefore + $amt;

    // Check if transaction already exists
    $sql = $link->prepare("SELECT * FROM fundwallet WHERE email = ? AND trxid = ?");
    $sql->bind_param("ss", $email, $transactionid);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $status = "error";
        $message = "Instance already exists";
        echo json_encode(array("status" => $status, "message" => $message));
        exit;
    }

    // Proceed if transaction status is successful and amount conditions are met
    if ($status == "successful" && $amount >= $amt && $currency == $curr) {
        // Calculate transaction fee
        $fee = $amount * $transaction_fee;
        $totalAmount = $amount + $fee;

        // Check if amount is within payment constraints
        if ($totalAmount < $minimal_payment || $totalAmount > $maximal_payment) {
            $status = "error";
            $message = "Amount not within allowed range";
            echo json_encode(array("status" => $status, "message" => $message));
            exit;
        }

        $dateTime = date("Y-m-d H:i:s");
        $reference = get_rand_alphanumeric(20);
        $gateWay = "FlutterWave";
        $currency = "NGN";

        // Insert into fundwallet table
        $sql = $link->prepare("INSERT INTO fundwallet (code, username, email, amount, channel, status, trxid, initiatedfrom, date, message, currency, balancebefore, balanceafter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("sssssssssssss", $reference, $username, $email, $amount, $payment_type, $status, $transactionid, $gateWay, $dateTime, $message, $currency, $balanceBefore, $balanceAfter);
        if ($sql->execute()) {
            // Update user's balance
            $sql = $link->prepare("UPDATE users SET vtubalance = vtubalance + ? WHERE username = ?");
            $sql->bind_param("ds", $amt, $username);
            if ($sql->execute()) {
                $status = "success";
                $message = "Wallet funded successfully";
                echo json_encode(array("status" => $status, "message" => $message));
                exit;
            } else {
                $status = "partial";
                $message = "Wallet funded but something went wrong";
                echo json_encode(array("status" => $status, "message" => $message));
                exit;
            }
        }
    } else {
        $status = "error";
        $message = "Wallet funding failed";
        echo json_encode(array("status" => $status, "message" => $message));
        exit;
    }
}

?> 