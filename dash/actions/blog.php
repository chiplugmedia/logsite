<?php

if(isset($_POST['addTasks'])){
    if($numrow_userTask > 0){
        $status="error";
        $message="You have performed this sponsored post task ";
        $genMsg=sendResponse($status, $message);
    }
    else if($numrow_task == 0){
        $status="error";
        $message="Sponsored post not found";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['desc'])){
        $status="error";
        $message="Something went wrong 002";
        $genMsg=sendResponse($status, $message);
    }
    else{
        $url="https://ovaltech.ng";
        $desc=filter_string($_POST['desc']);
        $sql=$link->prepare("INSERT INTO usersponsored(username, title, date) VALUES(?,?,?)");
        $sql->bind_param("sss", $username, $title, $dateTime);
        if($sql->execute()){
            $sql=$link->prepare("UPDATE users SET funds=funds + ? WHERE username=?");
            $sql->bind_param("ss", $amount, $username);
            $sql->execute();
            
            $type="Sponsored_ads";
            $sql=$link->prepare("INSERT INTO userearnings(username, type, amount, time, date) VALUES(?,?,?,?,?)");
            $sql->bind_param("sssss", $username, $type, $amount, $time, $dateTime);
            $sql->execute();
            
            $utf8_desc = utf8_encode($desc);
            
            
            $shareUrl="https://api.whatsapp.com/send?text=$utf8_desc";

            $status="success";
            $message="Sponsored post completed successfully (+ ₦$amount 👍) ";
            $genMsg=sendResponse($status, $message);
          header("location:$url");
           // header("Set-Cookie: $shareUrl", false);
        }
        else{
            $status="error";
            $message="Something went wrong";
            $genMsg=sendResponse($status, $message);
        }
    }
}
?>