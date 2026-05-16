<?php
$genMsg = "";

if (isset($_POST['purchaseprod'])) {
    // Check if reference is provided
    if (empty($_POST['reference'])) {
        $genMsg = sendResponse("error", "Reference is required");
    } else {
        // Sanitize and validate input
        $reference=filter_string($_POST['reference']);

        // Fetch product details using the reference
        $sql = $link->prepare("SELECT * FROM products WHERE reference = ?");
        $sql->bind_param("s", $reference);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_products = $result->num_rows;

        if ($numrow_products == 0) {
            $genMsg = sendResponse("error", "Invalid product");
        } else {
            $row = $result->fetch_assoc();
            $price = $row['price'];
            $stock = $row['name']; // Stock is represented by the 'name' field
            $purchaseinfo = $row['purchaseinfo'];
            $description = $row['description'];
            $status = "active"; // Assuming newStatus needs to be defined

            if ($price > $funds) {
                $status = "error";
                $message = "Insufficient funds in your wallet";
                $genMsg = sendResponse($status, $message);
            } else {
                // Start transaction
                $link->begin_transaction();

                // Deduct funds from the user's account
                $totalPrice = $price;
                $sql = $link->prepare("UPDATE users SET funds = funds - ? WHERE username = ?");
                $sql->bind_param("ds", $totalPrice, $username);
                $deductFunds = $sql->execute();

                // Insert purchase record for the user
                $sql = $link->prepare("INSERT INTO userpurchases(username, title, purchaseinfo, description, amount, status, reference, date) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                $sql->bind_param("sssdssss", $username, $stock, $purchaseinfo, $description, $price, $status, $reference, $dateTime);
                $insertPurchase = $sql->execute();

                if ($deductFunds && $insertPurchase) {
                    // Update the product status to 'sold'
                    $sql = $link->prepare("UPDATE products SET status = 'sold' WHERE reference = ?");
                    $sql->bind_param("s", $reference);
                    $updateProductStatus = $sql->execute();

                    if ($updateProductStatus) {
                        // Commit transaction
                        $link->commit();


// Fetch referral username
                    $sql = $link->prepare("SELECT referral FROM referrals WHERE username = ?");
                    $sql->bind_param("s", $username);
                    $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $refUsername = $row['referral'];

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
                        $time = time(); // Added missing time variable
                        $sql = $link->prepare("INSERT INTO userearnings(username, type, amount, time, date) VALUES(?, ?, ?, ?, ?)");
                        $sql->bind_param("sssss", $username, $typehg, $totalPrice, $time, $dateTime);
                        $sql->execute();

                        $status = "success";
                        $message = "Product purchased successfully.";
                        $genMsg = sendResponse($status, $message);

                        // Prepare the CSV content with only purchaseinfo
                        $csvContent = "Purchase Info\n"; // Column header
                        $csvContent .= $purchaseinfo; // Append the purchaseinfo

                        // Set the headers to download the CSV file
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename="purchase_info.csv"');
                        header('Content-Length: ' . strlen($csvContent));

                        // Output the CSV content for download
                        echo $csvContent;
                        exit; // Ensure script termination after download
                    } else {
                        // Rollback transaction in case of error updating product status
                        $link->rollback();
                        $status = "error";
                        $message = "Failed to update product status";
                        $genMsg = sendResponse($status, $message);
                    }
                } else {
                    // Rollback transaction in case of error
                    $link->rollback();
                    $status = "error";
                    $message = "Something went wrong 003";
                    $genMsg = sendResponse($status, $message);
                }
            }
        }
    }
}
?>
