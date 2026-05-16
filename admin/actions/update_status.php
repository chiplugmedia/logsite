<?php

$genMsg="";


// Save Admin Price
if (isset($_POST['saveprice'])) {

    $productID = $_POST['product_id'];
    $price = trim($_POST['override_price']); // remove spaces
    $dateTime = date('Y-m-d H:i:s'); // current timestamp

    if ($price === "") {
        // Delete override if price is empty
        $sql = $link->prepare("DELETE FROM adminprices WHERE product_id = ?");
        $sql->bind_param("s", $productID);

        if ($sql->execute()) {
            $status = "success";
            $message = "Admin price removed";
            $genMsg = sendResponse($status, $message);
        } else {
            $status = "error";
            $message = "Failed to remove price";
            $genMsg = sendResponse($status, $message);
        }

    } else {
        // Check if record exists
        $check = $link->prepare("SELECT id FROM adminprices WHERE product_id = ?");
        $check->bind_param("s", $productID);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            // Update existing record
            $update = $link->prepare("UPDATE adminprices SET override_price = ?, date = ? WHERE product_id = ?");
            $update->bind_param("sss", $price, $dateTime, $productID);

            if ($update->execute()) {
                $status = "success";
                $message = "Product price updated";
                $genMsg = sendResponse($status, $message);
            } else {
                $status = "error";
                $message = "Failed to update price";
                $genMsg = sendResponse($status, $message);
            }

        } else {
            // Insert new record
            $insert = $link->prepare("INSERT INTO adminprices (product_id, override_price, date) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $productID, $price, $dateTime);

            if ($insert->execute()) {
                $status = "success";
                $message = "Product price added";
                $genMsg = sendResponse($status, $message);
            } else {
                $status = "error";
                $message = "Failed to insert price";
                $genMsg = sendResponse($status, $message);
            }
        }
    }
}





// Check if reference and new_status are set
if(isset($_POST['reference'], $_POST['new_status'])) {
    // Prepare and bind parameters
    // Assuming $conn is already defined elsewhere in your code
    $sql = $conn->prepare("UPDATE products SET status = ? WHERE reference = ?");
    $sql->bind_param("ss", $_POST['new_status'], $_POST['reference']);

    // Execute the update query
    if ($sql->execute()) {
        // If the update was successful, return success message
        echo json_encode(array("success" => true, "message" => "Status updated successfully"));
    } else {
        // If an error occurred, return error message
        echo json_encode(array("success" => false, "message" => "Error updating status"));
    }
} else {
    // If reference or new_status is not set, return error message
    echo json_encode(array("success" => false, "message" => "Missing parameters"));
}
?>
