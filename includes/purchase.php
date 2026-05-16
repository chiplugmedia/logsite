<?php

$genMsg = "";

if (isset($_POST['purchaseapi'])) {
    if (empty($_POST['service'])) {
        echo "Service is required.";
    } elseif (empty($_POST['year'])) {
        echo "Year is required.";
    } elseif (empty($_POST['quantity'])) {
        echo "Quantity is required.";
    } else {
        $service = $_POST['service'];
        $year = $_POST['year'];
        $quantity = $_POST['quantity'];

        // Assuming $costPerUnit and $funds are defined somewhere in your code
        $totalPrice = $costPerUnit * $quantity;

        if ($totalPrice > $funds) {
            $status = "error";
            $message = "Insufficient funds in your wallet";
            $genMsg = sendResponse($status, $message);
        } else {
            // Start transaction
            $link->begin_transaction();

            // Deduct funds from the user's account
            $sql = $link->prepare("UPDATE users SET funds = funds - ? WHERE username = ?");
            $sql->bind_param("ds", $totalPrice, $username);
            $deductFunds = $sql->execute();

            if ($deductFunds) {
                // Define the API endpoint and parameters
                $domain = 'terzettosmm.com';
                $apiKey = 'zBSMqJ4iEVgLkq69Mp58oxU4xu85LN634';

                function purchaseAccount($data) {
                    global $domain, $apiKey;
                    if (!isset($data['service'], $data['year'], $data['quantity'])) {
                        return ['error' => 'Missing required parameters'];
                    }

                    $postFields = [
                        "service" => $data['service'],
                        "year" => $data['year'],
                        "quantity" => $data['quantity']
                    ];

                    $url = "https://api.$domain/api/buy-account/v1/purchase?key=$apiKey";
                    return apiRequest($url, $postFields, 'POST');
                }

                // Set the POST data
                $postData = [
                    "service" => $service,
                    "year" => $year,
                    "quantity" => $quantity
                ];

                // Execute the purchase account function
                $response = purchaseAccount($postData);

                // Check for errors
                if (isset($response['error'])) {
                    echo "Error: " . $response['error'];
                } else {
                    // Assuming $response contains HTTP status code and message
                    $httpStatusCode = $response['status_code'];

                    if ($httpStatusCode === 400) {
                        $status = "error";
                        $message = "Please fund your wallet to be able to purchase.";
                        $genMsg = sendResponse($status, $message);
                    } else {
                        $status = "success";

                        // Insert purchase record for the user
                        $sql = $link->prepare("INSERT INTO userpurchases(username, title, purchaseinfo, description, amount, status, reference, date) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                        $sql->bind_param("sssdssss", $username, $service, $itemDetails, $service, $totalPrice, $status, $reference, $dateTime);

                        $allSuccess = true;
                        for ($i = 1; $i <= $quantity; $i++) {
                            $reference = get_rand_alphanumeric(30);
                            if (!$sql->execute()) {
                                $allSuccess = false;
                                break;
                            }
                        }

                        if ($allSuccess) {
                            // Fetch referral username
                            $sql = $link->prepare("SELECT referral FROM referrals WHERE username = ?");
                            $sql->bind_param("s", $username);
                            $sql->execute();
                            $result = $sql->get_result();

                            if ($result->num_rows == 1) {
                                $row = $result->fetch_assoc();
                                $refUsername = $row['referral'];

                                // Calculate referral bonus (2% of the order amount)
                                $refBonus = $totalPrice * 0.02;

                                // Update referral's funds and total earnings
                                $sql = $link->prepare("UPDATE users SET referralfunds = referralfunds + ?, totalrefearnings = totalrefearnings + ? WHERE username = ?");
                                $sql->bind_param("dds", $refBonus, $refBonus, $refUsername);
                                $sql->execute();

                                // Insert referral bonus into userearnings table
                                $typeBonus = "Referral Bonus";
                                $sql = $link->prepare("INSERT INTO userearnings(username, type, amount, time, date) VALUES(?, ?, ?, ?, ?)");
                                $sql->bind_param("sssss", $refUsername, $typeBonus, $refBonus, $time, $dateTime);
                                $sql->execute();
                            }

                            // Log the user's earnings attempt
                            $typehg = "Purchased Product";
                            $time = time();
                            $sql = $link->prepare("INSERT INTO userearnings(username, type, amount, time, date) VALUES(?, ?, ?, ?, ?)");
                            $sql->bind_param("sssss", $username, $typehg, $totalPrice, $time, $dateTime);
                            $sql->execute();

                            $status = "success";
                            $message = "Product purchased successfully.";
                            $genMsg = sendResponse($status, $message);

                            // Prepare the CSV content with only purchaseinfo
                            $csvContent = "Purchase Info\n";
                            $csvContent .= $itemDetails;

                            // Set the headers to download the CSV file
                            header('Content-Type: text/csv');
                            header('Content-Disposition: attachment; filename="purchase_info.csv"');
                            header('Content-Length: ' . strlen($csvContent));

                            // Output the CSV content for download
                            echo $csvContent;
                            exit;
                        } else {
                            // Rollback transaction in case of error inserting purchase
                            $link->rollback();
                            $status = "error";
                            $message = "Failed to insert purchase record.";
                            $genMsg = sendResponse($status, $message);
                        }
                    }
                }
            } else {
                // Rollback transaction in case of error deducting funds
                $link->rollback();
                $status = "error";
                $message = "Failed to deduct funds.";
                $genMsg = sendResponse($status, $message);
            }
        }
    }
}
?>
