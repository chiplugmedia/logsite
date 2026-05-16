<?php
$genMsg="";

if (isset($_POST['update'])) {
    // Validate inputs
    if (empty($_POST['username'])) {
        $status = "error";
        $message = "Username is required";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['fullname'])) {
        $status = "error";
        $message = "Full name is required";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['phone'])) {
        $status = "error";
        $message = "Phone number is required";
        $genMsg = sendResponse($status, $message);
    } elseif (strlen($_POST['phone']) != 11) {
        $status = "error";
        $message = "Phone number must be 11 digits";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['funds'])) {
        $status = "error";
        $message = "Main balance is required";
        $genMsg = sendResponse($status, $message);
    } else {
        // Filter and sanitize inputs
        $username1 = filter_string($_POST['username']);
        $fullname = filter_string($_POST['fullname']);
        $phone = filter_string($_POST['phone']);
        $funds = filter_string($_POST['funds']);

        // Check if user exists
        $sql = $link->prepare("SELECT funds FROM users WHERE username=?");
        $sql->bind_param("s", $username1);
        $sql->execute();
        $result = $sql->get_result();
        $numrow = $result->num_rows;

        if ($numrow > 0) {
            // Update user details
            $sql = $link->prepare("UPDATE users SET fullname=?, phone=?, funds=? WHERE username=?");
            $sql->bind_param("ssss", $fullname, $phone, $funds, $username1);
            if ($sql->execute()) {
                $status = "success";
                $message = "Details have been updated";
                $genMsg = sendResponse($status, $message);
            } else {
                $status = "error";
                $message = "Failed to save details";
                $genMsg = sendResponse($status, $message);
            }
        } else {
            $status = "error";
            $message = "User not found";
            $genMsg = sendResponse($status, $message);
        }
    }
}

?>