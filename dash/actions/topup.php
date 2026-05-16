<?php

require $_SERVER['DOCUMENT_ROOT']."$stream/includes/topup.php";


$genMsg = ""; // Initialize message variable


if (isset($_POST['purchaseapi']) && !empty($_POST['purchaseapi'])) {

    // Validate inputs
    $id       = $_POST['id'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;
    $cost     = $_POST['cost'] ?? '';

    if (empty($id)) {
        $genMsg = sendResponse("error", "Product ID is required");

    } elseif (empty($quantity) || !is_numeric($quantity) || $quantity <= 0) {
        $genMsg = sendResponse("error", "Enter a valid quantity");

    } elseif (empty($cost) || !is_numeric($cost) || $cost <= 0) {
        $genMsg = sendResponse("error", "Enter a valid cost");

    } else {

        // Sanitize and calculate totals
        $productID    = filter_string($id);
        $quantity     = (int) $quantity;
        $pricePerUnit = (float) $cost;
        $totalPrice   = $pricePerUnit * $quantity;
        $funds        = (float) $funds;

        // Check user funds
        if ($totalPrice > $funds) {
            $genMsg = sendResponse("error", "Insufficient funds");

        } else {

            // ---------------- API PURCHASE ----------------
            $data = [
                "action"  => "buyProduct",
                "id"      => $productID,
                "amount"  => $quantity,
                "api_key" => $apiKey,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://$siteDesc/api/buy_product");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                curl_close($ch);
                $genMsg = sendResponse("error", "Can't buy at the moment");

            } else {

                curl_close($ch);
                $responseData = json_decode($response, true);

                // API failed / no money / out of stock
                if (!$responseData || !isset($responseData['status']) || $responseData['status'] !== "success") {
                    $genMsg = sendResponse("error", "Can't buy at the moment");

                } else {

                    // ---------------- SUCCESS ----------------
                    $transId    = $responseData['trans_id'] ?? get_rand_alphanumeric(12);
                    $msg        = $responseData['msg'] ?? '';
                    $codes      = $responseData['data'] ?? [];
                    $reference  = get_rand_alphanumeric(30);
                    $dateTime   = date("Y-m-d H:i:s");
                    $statusText = "Completed";
                    $title      = "Product Purchase";
                    $codesText  = implode("\n", $codes);

                    // Deduct funds AFTER API success
                    $updateFunds = $link->prepare("UPDATE users SET funds = funds - ? WHERE username = ?");
                    $updateFunds->bind_param("ds", $totalPrice, $username);

                    if ($updateFunds->execute()) {

                        // Insert purchase
                        $insertPurchase = $link->prepare("
                            INSERT INTO userpurchases 
                            (username, title, purchaseinfo, description, amount, message, status, reference, date)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $insertPurchase->bind_param(
                            "sssssdsss",
                            $username,
                            $title,
                            $codesText,
                            $productID,
                            $totalPrice,
                            $msg,
                            $statusText,
                            $reference,
                            $dateTime
                        );
                        $insertPurchase->execute();

                        // Log earnings
                        $typehg = "Purchased Product";
                        $time   = time();

                        $insertEarnings = $link->prepare("
                            INSERT INTO userearnings (username, type, amount, time, date)
                            VALUES (?, ?, ?, ?, ?)
                        ");
                        $insertEarnings->bind_param("ssdss", $username, $typehg, $totalPrice, $time, $dateTime);
                        $insertEarnings->execute();

                        // Auto download
                        if (!empty($codes)) {
                            header('Content-Type: text/plain');
                            header("Content-Disposition: attachment; filename={$reference}.txt");
                            header("Pragma: no-cache");
                            header("Expires: 0");

                            foreach ($codes as $code) {
                                echo $code . PHP_EOL;
                            }
                            exit();
                        } else {
                            $genMsg = sendResponse("error", "No codes returned from API.");
                        }

                    } else {
                        $genMsg = sendResponse("error", "Failed to deduct funds");
                    }
                }
            }
        }
    }
}


?>