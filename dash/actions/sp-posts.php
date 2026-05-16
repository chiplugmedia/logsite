<?php
$genMsg="";
$sql=$link->prepare("SELECT * FROM sponsoredpost WHERE SUBSTRING(date, 1, 10) = ? ");
$sql->bind_param("s", $date);
$sql->execute();
$result=$sql->get_result();
$numrow_task=$result->num_rows;
$row=$result->fetch_assoc();
$title=$image=$desc=$genMsg=$profileLink=$url=$desurl="";

if($numrow_task > 0){
    $title=$row['title'];    
    $amount=$sponsoredPostAmt;
    $desc=$row['description'];
    $image=$row['image'];
    $type=$row['type'];
    
    
    
    $sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type=?");
    $sql->bind_param("ss", $username, $type);
    $sql->execute();
    $result=$sql->get_result();
    $numrow_link=$result->num_rows;
    $row=$result->fetch_assoc();
    if($numrow_link > 0){
        $profileLink=$row['url'];
    }

}
else{
    $title="No daily task avaliable yet";
    $amount=0;
    $desc="There is no task avaliable at the moment, check back later";
}

$sql=$link->prepare("SELECT * FROM usersponsored WHERE SUBSTRING(date, 1, 10) = ? AND username=?");
$sql->bind_param("ss", $date, $username);
$sql->execute();
$result=$sql->get_result();
$numrow_userTask=$result->num_rows;
if($numrow_userTask > 0){
    $desc="You have performed the sponsored post task for today, wait till tomorrow for a new one";
}



if(isset($_POST['addTasks'])){
    if($numrow_userTask > 0){
        $status = "error";
        $message = "You have performed this sponsored post task";
        sendResponse($status, $message);
    }
    else if($numrow_task == 0){
        $status = "error";
        $message = "Sponsored post not found";
        sendResponse($status, $message);
    }
    else{
        // Fetch the type for redirection
        $sql = $link->prepare("SELECT type FROM sponsoredpost LIMIT 1");
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        $type = $row['type'];  // Assuming $type contains the URL for redirection

        // Insert into usersponsored
        $sql = $link->prepare("INSERT INTO usersponsored(username, title, amount, date) VALUES(?, ?, ?, ?)");
        $sql->bind_param("ssss", $username, $title, $amount, $dateTime);

        if($sql->execute()){
            // Update user funds
            $sql = $link->prepare("UPDATE users SET funds = funds + ? WHERE username = ?");
            $sql->bind_param("ss", $amount, $username);
            $sql->execute();
            
            // Insert into userearnings
            $typenox = "Noxen Post";
            $sql = $link->prepare("INSERT INTO userearnings(username, type, amount, time, date) VALUES(?, ?, ?, ?, ?)");
            $sql->bind_param("sssss", $username, $typenox, $amount, $time, $dateTime);
            $sql->execute();
            
            // Set success status and then redirect
            $status = "success";
            $message = "Sponsored post completed successfully (+ NP$amount 👍)";
            sendResponse($status, $message);

            // Redirect to the URL specified by $type
            header("Location: $type");
            exit();  // Ensure no further code is executed
        }
        else{
            $status = "error";
            $message = "Something went wrong";
            sendResponse($status, $message);
        }
    }
}

?>