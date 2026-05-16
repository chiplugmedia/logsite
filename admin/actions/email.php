<?php
$genMsg="";


// Check if the form is submitted
if (isset($_POST['sendEmail'])) {

    // Validate title and description
    if (empty($_POST['title']) || empty($_POST['desc'])) {
        $status = "error";
        $message = empty($_POST['title']) ? "Enter title" : "Enter message";
        $genMsg = sendResponse($status, $message);
        exit();  // Stop further processing
    }

    // Get title and description from the form
    $title = $_POST['title'];  // Get the email title
    $desc = $_POST['desc'];    // Get the message body

    // Prepare and execute query to fetch all users
    $role = 'user';  // Defining role
    $sql = $link->prepare("SELECT email, fullname FROM users WHERE role = ?");
    $sql->bind_param("s", $role);  // Bind role to query

    if (!$sql->execute()) {
        // If the query execution fails
        $status = "error";
        $message = "Database query failed";
        $genMsg = sendResponse($status, $message);
        exit(); // Stop further processing
    }

    // Fetch result of the query
    $result = $sql->get_result();

    // Check if users are found
    if ($result->num_rows > 0) {
        // Loop through all users and send email to each
        while ($row = $result->fetch_assoc()) {
            $email = $row['email'];
            $fullname = $row['fullname'];

            $message = $desc;
                    $subject = $title;
                    $type = "messagetousers";  // Type of message to send

                    // Send the email using the sendMail function
                    sendMail($email, $fullname, $message, $subject, $type);
        }

        // Success message after all emails are sent
        $status = "success";
        $message = "Message Sent successfully";
        $genMsg = sendResponse($status, $message);
    } else {
        // If no users are found
        $status = "error";
        $message = "No users found to send email to";
        $genMsg = sendResponse($status, $message);
    }
}

?>
