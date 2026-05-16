<?php
$genMsg = ""; // Initialize $genMsg before the conditionals

$adminMail = "young@gmail.com"; // Corrected variable name

if (isset($_POST['bankTransferFunding']) && !empty($_POST['bankTransferFunding'])) {

    // Validate required fields
    if (empty($_POST['amount'])) {
        $status = "error";
        $message = "Enter the amount you transferred";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['sendername'])) {
        $status = "error";
        $message = "Enter the sender name";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['paymentMethod'])) {
        $status = "error";
        $message = "Enter payment method";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_FILES['paymentProof']['name'])) {
        $status = "error";
        $message = "Upload image proof";
        $genMsg = sendResponse($status, $message);
    } else {

        // Sanitize inputs
        $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $sendername = filter_var($_POST['sendername'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $paymentMethod = filter_var($_POST['paymentMethod'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // File validation
        $allowedExtensions = ["png", "jpeg", "jpg"];
        $maxSize = 5 * 1024 * 1024; // 5MB

        $imageName = $_FILES['paymentProof']['name'];
        $imageTmpName = $_FILES['paymentProof']['tmp_name'];
        $imageSize = $_FILES['paymentProof']['size'];
        $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            $status = "error";
            $message = "File is not a valid image";
            $genMsg = sendResponse($status, $message);
        } elseif ($imageSize > $maxSize) {
            $status = "error";
            $message = "Invalid image size (Max size: 5MB)";
            $genMsg = sendResponse($status, $message);
        } else {
            // Generate new image name and reference
            $newImgName = get_rand_alphanumeric(10) . "." . $extension;
            $reference = get_rand_alphanumeric(20);

            // Ensure upload directory exists
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . trim($stream, "/") . DIRECTORY_SEPARATOR . "dash" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "directory" . DIRECTORY_SEPARATOR;
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $path = $uploadDir . $newImgName;
            if (move_uploaded_file($imageTmpName, $path)) {

                // Insert into bankdeposit
                $sql = $link->prepare("INSERT INTO bankdeposit (username, image, amount, sendername, method, reference, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $sql->bind_param("ssdssss", $username, $newImgName, $amount, $sendername, $paymentMethod, $reference, $dateTime);
                $sql->execute();

                // Fetch current balance from wallet
                // $balanceBefore = 0;
                $sqlBal = $link->prepare("SELECT funds FROM users WHERE username = ?");
                $sqlBal->bind_param("s", $username);
                $sqlBal->execute();
                $resBal = $sqlBal->get_result();
                if ($resBal->num_rows > 0) {
                    $balanceBefore = (float)$resBal->fetch_assoc()['funds'];
                }

                $balanceAfter = $balanceBefore + $amount; // new balance

                // // Update user's wallet
                // $sqlUpdate = $link->prepare("UPDATE users SET funds = ? WHERE username = ?");
                // $sqlUpdate->bind_param("ds", $amount, $username);
                // $sqlUpdate->execute();

                // Insert into fundwallet
                $currency = "Manual Deposit";
                $statusTrans = "pending"; // Set initial transaction status
                $transactionid = get_rand_alphanumeric(15);
                $gateWay = "Manual";
                $message = "Manual deposit initiated";

                $sql2 = $link->prepare("INSERT INTO fundwallet (code, username, email, amount, channel, status, trxid, initiatedfrom, date, message, currency, balancebefore, balanceafter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $sql2->bind_param(
                    "sssssssssssss",
                    $reference,
                    $username,
                    $email,
                    $amount,
                    $paymentMethod,
                    $statusTrans,
                    $transactionid,
                    $gateWay,
                    $dateTime,
                    $message,
                    $currency,
                    $balanceBefore,
                    $balanceAfter
                );
                $sql2->execute();

                $status = "success";
                $message = "Sent successfully. Your account will be credited shortly when confirmed by our team.";
                $genMsg = sendResponse($status, $message);

            } else {
                $status = "error";
                $message = "Error moving uploaded file";
                $genMsg = sendResponse($status, $message);
            }
        }
    }
}

?>
