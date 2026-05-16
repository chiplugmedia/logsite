<?php
$genMsg = ""; // Initialize general message variable

if (isset($_POST['questionqize'])) {
    // Check if correct_answer and reference are provided
    if (empty($_POST['correct_answer']) || empty($_POST['reference'])) {
        $status = "error";
        $message = "Please provide a correct answer and a reference";
        $genMsg = sendResponse($status, $message); // Assuming sendResponse function is defined elsewhere
    } else {
        // Sanitize inputs
        $correct_answer = filter_var($_POST['correct_answer'], FILTER_SANITIZE_STRING);
        $reference = filter_var($_POST['reference'], FILTER_SANITIZE_STRING);

        // Initialize variables
        $charge_amount = 1000; // Charge amount in naira
        $amount6 = 200; // Reward amount in naira for correct answer
        $amount60 = 0; // No reward for incorrect answer
        $dateTime = date('Y-m-d H:i:s'); // Current date and time

        // Assume $funds and $username are defined elsewhere
        if ($charge_amount > $funds) {
            $status = "error";
            $message = "Insufficient funds in your activity wallet";
            $genMsg = sendResponse($status, $message);
        } else {
            // Deduct the charge amount from user's funds
            $sql = $link->prepare("UPDATE users SET funds = funds - ? WHERE username = ?");
            $sql->bind_param("is", $charge_amount, $username);
            $sql->execute();

            // Prepare SQL to check if the user has answered this question before
            $sql = $link->prepare("SELECT * FROM user_answers WHERE username = ? AND reference = ?");
            $sql->bind_param("ss", $username, $reference);
            $sql->execute();
            $result = $sql->get_result();
            $numrow_user_answers = $result->num_rows;
            $sql->close(); // Close previous statement

            if ($numrow_user_answers > 0) {
                // User has already answered this question
                $status = "error";
                $message = "You have already answered this question.";
                $genMsg = sendResponse($status, $message);
                echo $genMsg; // Display the message
                exit; // Exit the script
            }

            // Proceed with checking if the answer is correct and updating rewards
            $sql = $link->prepare("SELECT * FROM questions WHERE reference = ?");
            $sql->bind_param("s", $reference);
            $sql->execute();
            $result = $sql->get_result();
            $row = $result->fetch_assoc();
            $numrow_question = $result->num_rows;
            $sql->close(); // Close previous statement

            if ($numrow_question == 0) {
                $status = "error";
                $message = "Invalid question";
                $genMsg = sendResponse($status, $message);
            } else {
                $question_text = $row['question_text'];

                // Check if another user has already answered this question
                $sql = $link->prepare("SELECT * FROM user_answers WHERE reference = ?");
                $sql->bind_param("s", $reference);
                $sql->execute();
                $result = $sql->get_result();
                $row_other_user_answer = $result->fetch_assoc();
                $numrow_other_user_answer = $result->num_rows;
                $sql->close(); // Close previous statement

                if ($numrow_other_user_answer > 0 && $row_other_user_answer['username'] !== $username) {
                    // Another user has already answered this question
                    $status = "info";
                    $message = "This question has already been answered by another user.";
                    $genMsg = sendResponse($status, $message);
                    echo $genMsg; // Display the message
                    exit; // Exit the script
                }

                // Check if the user's answer matches the correct answer
                $sql = $link->prepare("SELECT * FROM questions WHERE reference = ? AND correct_answer = ?");
                $sql->bind_param("ss", $reference, $correct_answer);
                $sql->execute();
                $result = $sql->get_result();
                $row = $result->fetch_assoc();
                $numrow_correct_answer = $result->num_rows;
                $sql->close(); // Close previous statement

                if ($numrow_correct_answer > 0) {
                    // Update user's funds if the answer is correct
                    $sql = $link->prepare("UPDATE users SET funds = funds + ? WHERE username = ?");
                    $sql->bind_param("is", $amount6, $username);
                    $sql->execute();

                    // Insert user's correct answer
                    $sql = $link->prepare("INSERT INTO user_answers(username, question_text, correct_answer, amount, reference, date) VALUES(?,?,?,?,?,?)");
                    $sql->bind_param("ssssss", $username, $question_text, $correct_answer, $amount6, $reference, $dateTime);
                    $sql->execute();

                    // Set success message
                    $status = "success";
                    $message = "Congratulations! You have earned $amount6 reward points.";
                    $genMsg = sendResponse($status, $message); // Assuming sendResponse function is defined elsewhere

                    // Log the user's earnings attempt
                    $type = "Noxen Brain Teaser(quiz) You have earned $amount6 reward points.";
                    $time = ""; // Define $time variable if it's not defined
                    $sql = $link->prepare("INSERT INTO userearnings(username, type, amount, time, date) VALUES(?,?,?,?,?)");
                    $sql->bind_param("sssss", $username, $type, $amount6, $time, $dateTime);
                    $sql->execute();
                } else {
                    // If answer is incorrect
                    $status = "error";
                    $message = "Sorry, your answer was incorrect.";
                    $genMsg = sendResponse($status, $message); // Assuming sendResponse function is defined elsewhere

                    // Insert user's incorrect answer
                    $sql = $link->prepare("INSERT INTO user_answers(username, question_text, correct_answer, amount, reference, date) VALUES(?,?,?,?,?,?)");
                    $sql->bind_param("ssssss", $username, $question_text, $correct_answer, $amount60, $reference, $dateTime);
                    $sql->execute();
                }
            }
        }
    }
}


?>
