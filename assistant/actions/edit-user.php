<?php
$genMsg="";

if(isset($_POST['update'])){
    if(empty($_POST['username'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['fullname'])){
        $status="error";
        $message="Enter a fullname"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['phone'])){
        $status="error";
        $message="Enter a phone number";
        $genMsg=sendResponse($status, $message);
    }
    else if(strlen($_POST['phone']) != 11){
        $status="error";
        $message="Invalid phone number";
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['funds'] == ""){
        $status="error";
        $message="Enter main balance";
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['referralFunds'] == ""){
        $status="error";
        $message="Enter referral funds";
        $genMsg=sendResponse($status, $message);
    }
    
    
    else{
        $username1=filter_string($_POST['username']);
        $phone=filter_string($_POST['phone']);
        $funds=filter_string($_POST['funds']);
        $referralFunds=filter_string($_POST['referralFunds']);
        //$activityFunds=filter_string($_POST['activityFunds']);
        $sql=$link->prepare("SELECT * FROM users WHERE username=?");
        $sql->bind_param("s", $username1);
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        $row=$result->fetch_assoc();
        $fundsBefore=$referralFundsBefore=$activityFundsBefore=0;
        if($numrow > 0){
            $fundsBefore=$row['funds'];
            $referralFundsBefore=$row['referralfunds'];
            $activityFundsBefore=$row['funds'];
        }

        $sql=$link->prepare("UPDATE users SET fullname=?, phone=?, funds=?, referralfunds=?, activityfunds=? WHERE username=?");
        $sql->bind_param("ssssss", $fullname, $phone, $funds, $referralFunds, $activityFunds, $username1);
        if($sql->execute()){
            $sql=$link->prepare("INSERT INTO updatedusers(username, updatedby, fundsbefore, fundsafter, referralfundsbefore, referralfundsafter, date) VALUES(?,?,?,?,?,?,?)");
            $sql->bind_param("sssssss", $username1, $username, $fundsBefore, $funds, $referralFundsBefore, $referralFunds, $dateTime);
            $sql->execute();
            $status="success";
            $message="Details has been updated";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Failed to save details";
            $genMsg=sendResponse($status, $message);
        }
    }
}
?>