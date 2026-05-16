<?php
$genMsg="";
if (isset($_POST['addTask'])) {
    if (empty($_POST['reference'])) {
        $status = "error";
        $message = "Reference and URL are required";
        $genMsg = sendResponse($status, $message);
    } else {
        // Validate and filter inputs
        $reference = filter_input(INPUT_POST, 'reference', FILTER_SANITIZE_STRING);

        // Check if an image is uploaded
        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            // Ensure the upload directory exists and has correct permissions
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/dash/img/userstask/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $uploadFile = $uploadDir . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $image = $_FILES['image']['name']; // Store file name
            } else {
                $status = "error";
                $message = "Failed to move uploaded file.";
                $genMsg = sendResponse($status, $message);
                error_log("Failed to move uploaded file to $uploadFile");
                exit;
            }
        } else {
            $status = "error";
            $message = "No image uploaded or there was an upload error";
            $genMsg = sendResponse($status, $message);
            exit;
        }

        // Check if task already exists for the user
        $sql = $link->prepare("SELECT * FROM usersocaltasks WHERE username=? AND reference=?");
        $sql->bind_param("ss", $username, $reference);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_userTask = $result->num_rows;

        // Check if task with the given reference exists
        $sql = $link->prepare("SELECT * FROM socaltasks WHERE reference=?");
        $sql->bind_param("s", $reference);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_task = $result->num_rows;
        $row = $result->fetch_assoc();

        if ($numrow_userTask > 0) {
            $status = "error";
            $message = "You have already performed this Social task";
            $genMsg = sendResponse($status, $message);
        } elseif ($numrow_task == 0) {
            $status = "error";
            $message = "Invalid task";
            $genMsg = sendResponse($status, $message);
        } else {
            // Insert task and update user earnings
            $amount = $row['amount'];
            $postTitle = $row['title'];
            $postUrl = $row['url'];
            $newStatus = "pending";

            $sql = $link->prepare("INSERT INTO usersocaltasks (username, title, url, amount, image, status, reference, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->bind_param("ssssssss", $username, $postTitle, $postUrl, $amount, $image, $newStatus, $reference, $dateTime);
            if ($sql->execute()) {
                $type = "Social task";
                $sql = $link->prepare("INSERT INTO userearnings (username, type, amount, time, date) VALUES (?, ?, ?, ?, ?)");
                $sql->bind_param("sssss", $username, $type, $amount, $time, $dateTime);
                if ($sql->execute()) {
                    $status = "success"; // Correctly set the status
                    $message = "Social task completed successfully (+ $amount $point 👍)";
                    $genMsg = sendResponse($status, $message);
                } else {
                    $status = "error";
                    $message = "Something went wrong 003: " . $sql->error;
                    $genMsg = sendResponse($status, $message);
                }
            }
        }
    }
}

?>
