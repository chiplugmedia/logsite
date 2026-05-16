<?php


require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

$genMsg="";

// Store secret key in configuration
define('FLW_SECRET_KEY', 'FLWSECK-55a60a61eb49ece8e1cc17521b597318-19b5d2f12f3vt-X');
// define('SITE_URL', 'https://pinatexlogs.com');


function verifyFlutterWaveByRef($tx_ref) {
    $url = "https://api.flutterwave.com/v3/transactions/verify_by_reference?tx_ref=" . urlencode($tx_ref);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . FLW_SECRET_KEY,
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

$tx_ref = $_GET['tx_ref'] ?? $_GET['transactionid'] ?? '';

if (!$tx_ref) {
    echo sendResponse("error", "Invalid transaction reference");
} else {

    $verify = verifyFlutterWaveByRef($tx_ref);

    if (!$verify || $verify['status'] !== 'success') {
        echo sendResponse("error", "Verification failed");
        echo "<script>
            setTimeout(() => {
                location.href = '$stream/dash/deposit.php';
            }, 3000);
        </script>";
    } else {

        $data = $verify['data'];

        if ($data['status'] !== 'successful' || $data['currency'] !== 'NGN') {
            echo sendResponse("error", "Transaction not successful");
            echo "<script>
                setTimeout(() => {
                    location.href = '$stream/dash/deposit.php';
                }, 3000);
            </script>";
        } else {

            $amount = $data['amount'];

            // Prevent duplicate transaction
            $chk = $link->prepare("SELECT status, email FROM fundwallet WHERE trxid = ?");
            $chk->bind_param("s", $tx_ref);
            $chk->execute();
            $trx = $chk->get_result()->fetch_assoc();

            if ($trx && $trx['status'] === 'successful') {
                echo sendResponse("success", "Transaction already processed");
            } else {

                // Get user email from fundwallet or Flutterwave data
                // $email = $trx['email'] ?? $data['customer']['email'] ?? '';
                $email = $trx['email'];

                if (!$email) {
                    echo sendResponse("error", "User email not found");
                } else {

                    // Get user info
                    $sql = $link->prepare("SELECT username, funds FROM users WHERE email = ?");
                    $sql->bind_param("s", $email);
                    $sql->execute();
                    $result = $sql->get_result();

                    if ($result->num_rows !== 1) {
                        echo sendResponse("error", "User not found");
                    } else {

                        $row = $result->fetch_assoc();
                        $username = $row['username'];
                        $balanceBefore = $row['funds'];
                        $balanceAfter  = $balanceBefore + $amount;

                        try {
                            $link->begin_transaction();

                            // Update fundwallet
                            $upd1 = $link->prepare("
                                UPDATE fundwallet 
                                SET status = 'successful',
                                    amount = ?,
                                    balancebefore = ?,
                                    balanceafter = ?,
                                    message = 'Payment confirmed'
                                WHERE trxid = ?
                            ");
                            $upd1->bind_param("ddds", $amount, $balanceBefore, $balanceAfter, $tx_ref);
                            if (!$upd1->execute()) throw new Exception("Failed to update fundwallet");

                            // Update user wallet
                            $upd2 = $link->prepare("UPDATE users SET funds = funds + ? WHERE username = ?");
                            $upd2->bind_param("ds", $amount, $username);
                            if (!$upd2->execute()) throw new Exception("Failed to update user wallet");

                            $link->commit();

                            echo sendResponse("success", "Wallet funded successfully");

                            echo "<script>
                                setTimeout(() => {
                                    location.href = '$stream/dash/deposit.php';
                                }, 3000);
                            </script>";

                        } catch (Exception $e) {
                            $link->rollback();
                            echo sendResponse("error", "Transaction failed: " . $e->getMessage());
                        }

                    } // end else for user found

                } // end else for email exists

            } // end else for transaction not already successful

        } // end else for transaction successful

    } // end else for verification success

} // end else for tx_ref exists

?>

<link rel="stylesheet" href="/young/sweet.css">
 <script src="/young/sweet.js"></script>
 