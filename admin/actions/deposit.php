<?php
$genMsg="";

if(isset($_POST['approve'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $id=filter_string($_POST['id']);
        $sql=$link->prepare("SELECT * FROM bankdeposit WHERE id=?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result=$sql->get_result();
        $row=$result->fetch_assoc();
        $amount=$row['amount'];
        $username=$row['username'];
        $method=$row['method'];
        $status=$row['status'];
        $reference=$row['reference'];
        
        $sql=$link->prepare("SELECT * FROM users WHERE username=?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result=$sql->get_result();
        $row=$result->fetch_assoc();
        $email=$row['email'];
        $funds=$row['funds'];
        
        if($status == "successful"){
            $status="error";
            $message="Deposit is already successful"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $sql=$link->prepare("UPDATE bankdeposit SET status='successful' WHERE id=?");
            $sql->bind_param("i", $id);
            if($sql->execute()){
                $balanceBefore=$funds;
                $balanceAfter=$balanceBefore + $amount;

                $sql=$link->prepare("UPDATE users SET funds=funds + ? WHERE username=?");
                $sql->bind_param("ds", $amount, $username);
                $sql->execute();
                
                $message="Deposit";
                $subject="Deposit on $sitename approved";
                $type="adminMail";
                sendMail($email, $fullname, $message, $subject, $type);
            
                $status="success";
                $message="Deposit approved"; 
                $genMsg=sendResponse($status, $message);
            }
            else{
                $status="error";
                $message="Something went wrong"; 
                $genMsg=sendResponse($status, $message);
            }
        }
    }
}


if(isset($_POST['decline'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $id=filter_string($_POST['id']);
        $sql=$link->prepare("UPDATE bankdeposit SET status='rejected' WHERE id=?");
        $sql->bind_param("i", $id);
        if($sql->execute()){
            $status="success";
            $message="Deposit rejected"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}








if (isset($_POST['tiktokapprove'])) {
    if (empty($_POST['id'])) {
        $status = "error";
        $message = "Something went wrong";
        $genMsg = sendResponse($status, $message);
    } else {
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $sql = $link->prepare("SELECT * FROM tiktok_requests WHERE id=?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $views = $row['views'];
            $username = $row['username'];
            $tiktokname = $row['tiktokname'];
            $status = $row['status'];
            $reference = $row['reference'];
            $amount = 0;

            // Check if views are 1000 and set the amount
            if ($views == 1000) {
                $amount = 1200;

                $sql = $link->prepare("SELECT * FROM users WHERE username=?");
                $sql->bind_param("s", $username);
                $sql->execute();
                $result = $sql->get_result();
                $row = $result->fetch_assoc();
                $email = $row['email'];
                $spinovfund = $row['spinovfund'];

                if ($status == "successful") {
                    $status = "error";
                    $message = "User tiktok request is already successful";
                    $genMsg = sendResponse($status, $message);
                } else {
                    $sql = $link->prepare("UPDATE tiktok_requests SET status='successful' WHERE id=?");
                    $sql->bind_param("i", $id);
                    if ($sql->execute()) {
                        $balanceBefore = $spinovfund;
                        $balanceAfter = $balanceBefore + $amount;

                        $sql = $link->prepare("UPDATE users SET spinovfund=spinovfund + ? WHERE username=?");
                        $sql->bind_param("ds", $amount, $username);
                        $sql->execute();

                        $status = "success";
                        $message = "User tiktok request approved";
                        $genMsg = sendResponse($status, $message);
                    } else {
                        $status = "error";
                        $message = "Something went wrong";
                        $genMsg = sendResponse($status, $message);
                    }
                }
            } else {
                $status = "error";
                $message = "Views are not 1000, cannot proceed";
                $genMsg = sendResponse($status, $message);
            }
        } else {
            $status = "error";
            $message = "Invalid request ID";
            $genMsg = sendResponse($status, $message);
        }
    }
}




if(isset($_POST['tiktokdecline'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $id=filter_string($_POST['id']);
        $sql=$link->prepare("UPDATE tiktok_requests SET status='rejected' WHERE id=?");
        $sql->bind_param("i", $id);
        if($sql->execute()){
            $status="success";
            $message="User tiktok requests rejected"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}




?>