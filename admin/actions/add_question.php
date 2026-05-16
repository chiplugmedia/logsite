<?php
$genMsg = $question_text = $correct_answer = "";
$answers = array();

if(isset($_POST['addquestion'])){
    if(!empty($_POST['question_text'])){
        $question_text = filter_string($_POST['question_text']);
    } else {
        $status = "error";
        $message = "Enter question";
        $genMsg = sendResponse($status, $message);
    }

    if(!empty($_POST['correct_answer'])){
        $correct_answer = filter_string($_POST['correct_answer']);
    } else {
        $status = "error";
        $message = "Enter correct_answer";
        $genMsg = sendResponse($status, $message);
    }

    if(!empty($_POST['answers'])){
        $answers = $_POST['answers'];
    } else {
        $status = "error";
        $message = "Enter at least one answer";
        $genMsg = sendResponse($status, $message);
    }

    if(empty($genMsg)) {
        $reference = get_rand_alphanumeric(10);
        $dateTime = date('Y-m-d H:i:s'); // Current date and time

        // Prepare and execute SQL query
        $sql = $link->prepare("INSERT INTO questions (question_text, correct_answer, reference, date) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $question_text, $correct_answer, $reference, $dateTime);

        if($sql->execute()){
            // Inserting answers into another table
            $question_id = $link->insert_id; // Get the ID of the inserted question
            foreach($answers as $answer){
                $sql_answer = $link->prepare("INSERT INTO answers (question_id, answer_text) VALUES (?, ?)");
                $sql_answer->bind_param("is", $question_id, $answer);
                $sql_answer->execute();
            }

            $status = "success";
            $message = "Question uploaded successfully";
            $genMsg = sendResponse($status, $message);
        } else {
            $status = "error";
            $message = "Failed to upload Question";
            $genMsg = sendResponse($status, $message);
        }
    }
}
?>
