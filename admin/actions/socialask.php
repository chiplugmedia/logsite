<?php
$title=$desc=$titleErr=$descErr=$taskMsg=$urlErr=$url=$type=$typeErr=$isSelectedFb=$isSelectedYt=$isSelectedTw=$isSelectedIg=$isSelectedtg=$genMsg="";

if(isset($_POST['postTask'])){


    if(!empty($_POST['title'])){
        $title=$_POST['title'];
    }
    if(!empty($_POST['desc'])){
        $desc=$_POST['desc'];
    }
    if(!empty($_POST['url'])){
        $url=$_POST['url'];
    }
    if(!empty($_POST['amount'])){
        $amount=$_POST['amount'];
    }
    if(!empty($_POST['type'])){
        $type=$_POST['type'];
        if($type == "facebook"){
            $isSelectedFb="selected";
        }
        else if($type == "youtube"){
            $isSelectedYt="selected";
        }
        else if($type == "twitter"){
            $isSelectedTw="selected";
        }
        else if($type == "instagram"){
            $isSelectedIg="selected";
        }
        else if($type == "telegram"){
            $isSelectedtg="selected";
        }
        
    }

    if(empty($_POST['title'])){
        $status="error";
        $message="Enter post title"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['url'])){
        $status="error";
        $message="Enter post url"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['type'])){
        $status="error";
        $message="Enter social media type";
        $typeErr=sendResponse($status, $message);
    }
    else if(empty($_POST['desc'])){
        $status="error";
        $message="Enter post description"; 
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['amount'] == ""){
        $status="error";
        $message="Enter amount"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['amount'])){
        $status="error";
        $message="Enter a valid amount"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $title=filter_string($_POST['title']);
        $desc=filter_string($_POST['desc']);
        $url=filter_string($_POST['url']);
        $amount=filter_string($_POST['amount']);
        $type=filter_string($_POST['type']);
        $reference=get_rand_alphanumeric(10);
        $status="active";
        $sql=$link->prepare("INSERT INTO socaltasks(title, description, url, type, status, reference, amount, date) VALUES(?,?,?,?,?,?,?,?)");
        $sql->bind_param("ssssssss", $title, $desc, $url, $type, $status, $reference, $amount, $dateTime);
        if($sql->execute()){
            
            $status="success";
            $message="Social task added";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong adding task";
            $genMsg=sendResponse($status, $message);
        }
    }
}

if(isset($_POST['deletePost'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Something went wrongk"; 
        $genMsg=sendResponse($status, $message);
    } 
    else{
        $id=filter_string($_POST['id']);
        $sql=$link->prepare("SELECT * FROM socaltasks WHERE id=?");
        $sql->bind_param("s", $id);
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        $row=$result->fetch_assoc();
        if($numrow == 1){
            $image=$row['image'];
            $sql=$link->prepare("DELETE FROM socaltasks WHERE id=?");
            $sql->bind_param("i", $id);
            if($sql->execute()){
                $path=$_SERVER['DOCUMENT_ROOT']."$stream/assets/images/socaltasks/$image";
                unlink($path); 
                $status="success";
                $message="Sponsored post deleted";
                $genMsg=sendResponse($status, $message);
            }
            else{
                $status="error";
                $message="Something went wrong";
                $genMsg=sendResponse($status, $message);
            }    
        }
        else{
            $status="error";
            $message="Something went wrong";
            $genMsg=sendResponse($status, $message);
        }
    } 
}


if (isset($_POST['completePost'])) {
    if (empty($_POST['id'])) {
        $status = "error";
        $message = "Something went wrong"; 
        $genMsg = sendResponse($status, $message);
    } else {
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $sql = $link->prepare("SELECT * FROM socaltasks WHERE reference=?");
        $sql->bind_param("s", $id);
        $sql->execute();
        $result = $sql->get_result();
        $numrow = $result->num_rows;

        if ($numrow == 1) {
            $amount = $result->fetch_assoc()['amount'];

            $sql_usersocaltasks = $link->prepare("SELECT * FROM usersocaltasks WHERE reference=? AND status='pending'");
            $sql_usersocaltasks->bind_param("s", $id);
            $sql_usersocaltasks->execute();
            $result_usersocaltasks = $sql_usersocaltasks->get_result();
            $numrow_usersocaltasks = $result_usersocaltasks->num_rows;

            if ($numrow_usersocaltasks > 0) {
                $count = 0;

                while ($row_usersocaltasks = $result_usersocaltasks->fetch_assoc()) {
                    $username = $row_usersocaltasks['username'];

                    $sql_user = $link->prepare("UPDATE users SET score = score + ? WHERE username=?");
                    $sql_user->bind_param("ss", $amount, $username);

                    if ($sql_user->execute()) {
                        $count++;

                        $sql_user_update = $link->prepare("UPDATE usersocaltasks SET status='completed' WHERE username=? AND reference=?");
                        $sql_user_update->bind_param("ss", $username, $id);
                        $sql_user_update->execute();
                    }
                }

                if ($count == $numrow_usersocaltasks) {
                    $status = "success";
                    $message = "Pending user tasks have been credited and marked as completed"; 
                    $genMsg = sendResponse($status, $message);
                } else {
                    $status = "error";
                    $message = "Something went wrong marking tasks"; 
                    $genMsg = sendResponse($status, $message);
                }
            } else {
                $status = "error";
                $message = "No pending tasks were found"; 
                $genMsg = sendResponse($status, $message);
            }
        } else {
            $status = "error";
            $message = "Task was not found"; 
            $genMsg = sendResponse($status, $message);
        }
    }
}


if(isset($_POST['approve'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $id=filter_string($_POST['id']);
        $sql=$link->prepare("SELECT * FROM usersocaltasks WHERE id=?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result=$sql->get_result();
        $row=$result->fetch_assoc();
        $amount=$row['amount'];
        $username=$row['username'];
        $reference=$row['reference'];
        
        $sql=$link->prepare("SELECT * FROM users WHERE username=?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result=$sql->get_result();
        $row=$result->fetch_assoc();
        $score=$row['score'];
        


        if($status == "completed"){
            $status="error";
            $message="User Social Task is already successful"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $sql=$link->prepare("UPDATE usersocaltasks SET status='completed' WHERE id=?");
            $sql->bind_param("i", $id);
            if($sql->execute()){
                
                $sql=$link->prepare("UPDATE users SET score=score + ? WHERE username=?");
                $sql->bind_param("ss", $amount, $username);
                $sql->execute();
                
                
                $status="success";
                $message="User Social Task approved"; 
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
        $sql=$link->prepare("UPDATE usersocaltasks SET status='rejected' WHERE id=?");
        $sql->bind_param("i", $id);
        if($sql->execute()){
            $status="success";
            $message="User Social Task rejected"; 
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