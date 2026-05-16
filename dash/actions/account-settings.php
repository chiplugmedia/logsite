<?php
$genMsg="";
if(isset($_POST['saveProfile'])){

    if(!empty($_POST['fullname'])){
        $fullname=$_POST['fullname'];
    }
    if(!empty($_POST['phone'])){
        $phoneNumber=$_POST['phone'];
    }

    if(empty($_POST['fullname'])){
        $status="error";
        $message="Enter your fullname";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['phone'])){
        $status="error";
        $message="Enter your phone number";
        $genMsg=sendResponse($status, $message);
    }
    else{
        $fullname=filter_string($_POST['fullname']);
        $phone=filter_string($_POST['phone']);

        if(isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0){
            $imageName=$_FILES['image']['name'];
            $imageType=$_FILES['image']['type'];
            $imageTmpName=$_FILES['image']['tmp_name'];
            $imageSize=$_FILES['image']['size'];
            $imgExtArr=explode(".", $imageName);
            $newImgName=get_rand_alphanumeric(10).".".end($imgExtArr);
            $allowed=array("png" => "image/png", "jpeg" => "image/jpeg", "jpg" => "image/jpg", "heic" => "application/octet-stream");
            $maxSize=5 * 1024 * 1024;
            $extension=strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            if(!array_key_exists($extension, $allowed)){
                $status="error";
                $message="File is not an image";
                $genMsg=sendResponse($status, $message);   
            }
            else if(!in_array($imageType, $allowed)){
                $status="error";
                $message="File is not an image";
                $genMsg=sendResponse($status, $message);   
            }
            else if($imageSize > $maxSize){
                $status="error";
                $message="Image is too big, max size: 5MB";
                $genMsg=sendResponse($status, $message);   
            }
            else{
                $sql=$link->prepare("UPDATE users SET fullname=?, phone=? WHERE username=?");
                $sql->bind_param("sss", $fullname, $phone, $username);
                if($sql->execute()){
                    $sql=$link->prepare("UPDATE users SET image=? WHERE username=?");
                    $sql->bind_param("ss", $newImgName, $username);
                    $sql->execute();
                    if($profileImg != "default.png"){
                        $oldPath=$_SERVER['DOCUMENT_ROOT']."$stream/dash/assets/img/profilephotos/$profileImg";
                        unlink($oldPath);
                    }
                                    
                    $path=$_SERVER['DOCUMENT_ROOT']."$stream/dash/assets/img/profilephotos/$newImgName";
                    move_uploaded_file($imageTmpName, $path);
                    $profileImg=$newImgName;

                    $status="success";
                    $message="User Details has been saved";
                    $genMsg=sendResponse($status, $message);
                }
                else{
                    $status="error";
                    $message="Failed to save details";
                    $genMsg=sendResponse($status, $message);
                }  
            }
        }
        else{
            $sql=$link->prepare("UPDATE users SET fullname=?, phone=? WHERE username=?");
            $sql->bind_param("sss", $fullname, $phone, $username);
            if($sql->execute()){
                $status="success";
                $message="User Details has been saved";
                $genMsg=sendResponse($status, $message);
            }
            else{
                $status="error";
                $message="Failed to save details";
                $genMsg=sendResponse($status, $message);
            }
        }
    }
}



if(isset($_POST['deleteImg'])){
    $sql=$link->prepare("UPDATE users SET image='default.png' WHERE username=?");
    $sql->bind_param("s", $username);
    if($sql->execute()){
        if($profileImg != "default.png"){
            $oldPath=$_SERVER['DOCUMENT_ROOT']."$stream/dash/assets/img/profilephotos/$profileImg";
            unlink($oldPath);
        }
        $profileImg="default.png";
        $status="success";
        $message="Profile photo deleted";
        $genMsg=sendResponse($status, $message);
    }
    
}


if(isset($_POST['saveBank'])){
   
    if(!empty($_POST['bankName'])){
        $bankName=$_POST['bankName'];
    }
    if(!empty($_POST['acctName'])){
        $acctName=$_POST['acctName'];
    }
    if(!empty($_POST['acctNum'])){
        $acctNum=$_POST['acctNum'];
    }

    if(empty($_POST['bankName'])){
        $status="error";
            $message="Select your bank name"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['acctName'])){
        $status="error";
        $message="Enter your account name";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['acctNum'])){
        $status="error";
        $message="Enter your account number";
        $genMsg=sendResponse($status, $message);
    }
    else{
        $bankAndCode=filter_string($_POST['bankName']);
        $bankAndCode=explode("_", $bankAndCode);
        $bankCode=$bankAndCode[0];
        $bankName=$bankAndCode[1];
        $acctName=filter_string($_POST['acctName']);
        $acctNum=filter_string($_POST['acctNum']);

        $sql=$link->prepare("SELECT * FROM bankaccounts WHERE username=?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        

        if($numrow == 0){
            $sql=$link->prepare("INSERT INTO bankaccounts(username, bankname, acctname, acctnum, bankcode, date) VALUES(?,?,?,?,?,?)");
            $sql->bind_param("ssssss", $username, $bankName, $acctName, $acctNum, $bankCode, $dateTime);
        }
        else{
            $sql=$link->prepare("UPDATE bankaccounts SET  bankname=?, acctname=?, acctnum=?, bankcode=? WHERE username=?");
            $sql->bind_param("sssss", $bankName, $acctName, $acctNum, $bankCode, $username);
        }
        if($sql->execute()){
            $status="success";
            $message="Bank Details has been saved";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Failed to save details";
            $genMsg=sendResponse($status, $message);
        }
    }
}


if(isset($_POST['updateProfileLinks'])){

    if(!empty($_POST['facebook'])){
        $facebook=$_POST['facebook'];
    }   
    if(!empty($_POST['instagram'])){
        $instagram=$_POST['instagram'];
    }
    if(!empty($_POST['whatsapp'])){
        $whatsapp=$_POST['whatsapp'];
    }
    if(!empty($_POST['twitter'])){
        $twitter=$_POST['twitter'];
    }   

    if(empty($_POST['facebook'])){
        $status="error";
        $message="Enter your facebook profile link";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['twitter'])){
        $status="error";
        $message="Enter your twitter link";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['instagram'])){
        $status="error";
        $message="Enter your instagram link";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['whatsapp'])){
        $status="error";
        $message="Enter your whatsapp number";
        $genMsg=sendResponse($status, $message);
    }
    else{
        $facebook=filter_string($_POST['facebook']);
        $twitter=filter_string($_POST['twitter']);
        $instagram=filter_string($_POST['instagram']);
        $whatsapp=filter_string($_POST['whatsapp']);

        $sql=$link->prepare("SELECT * FROM profilelinks WHERE username=?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;

        if($numrow == 0){
            $sql=$link->prepare("INSERT INTO profilelinks(username, type, url, date) VALUES(?,?,?,?)");
            $sql->bind_param("ssss", $username, $type, $url, $dateTime);

            $type="facebook";
            $url=$facebook;
            $sql->execute();
            $type="twitter";
            $url=$twitter;
            $sql->execute();
            $type="whatsapp";
            $url=$whatsapp;
            $sql->execute();
            $type="instagram";
            $url=$instagram;
            $sql->execute();
        }
        else{
            $sql=$link->prepare("UPDATE profilelinks SET url=? WHERE username=? AND type=?");
            $sql->bind_param("sss", $url, $username, $type);

            $type="facebook";
            $url=$facebook;
            $sql->execute();
            $type="twitter";
            $url=$twitter;
            $sql->execute();
            $type="whatsapp";
            $url=$whatsapp;
            $sql->execute();
            $type="instagram";
            $url=$instagram;
            $sql->execute();
        }
        
        $status="success";
        $message="Profile links has been saved";
        $genMsg=sendResponse($status, $message);
    }
}


if(isset($_POST['saveSocial'])){
   
    if(empty($_POST['twUsername'])){
        $status="error";
        $message="Enter your twitter username"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['fbUsername'])){
        $status="error";
        $message="Enter your facebook username";
        $genMsg=sendResponse($status, $message);
    }
    if(empty($_POST['igUsername'])){
        $status="error";
        $message="Enter your instagram username"; 
        $genMsg=sendResponse($status, $message);
    }
    if(empty($_POST['ytUsername'])){
        $status="error";
        $message="Enter your whatsapp number"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $twUsername=filter_string($_POST['twUsername']);
        $fbUsername=filter_string($_POST['fbUsername']);
        $igUsername=filter_string($_POST['igUsername']);
        $ytUsername=filter_string($_POST['ytUsername']);
        
        if($profileLinkRow){
            $sql=$link->prepare("UPDATE profilelinks SET socialusername=?, type=? WHERE username=?");
            $sql->bind_param("sss", $socialUsername, $type, $username);
        }
        else{
            $sql=$link->prepare("INSERT INTO profilelinks(username, socialusername, type, date) VALUES(?,?,?,?)");
            $sql->bind_param("ssss", $username, $socialUsername, $type, $dateTime);
        }
        $socialUsername=$twUsername;
        $type="twitter";
        $sql->execute();
        $socialUsername=$igUsername;
        $type="instagram";
        $sql->execute();
        $socialUsername=$ytUsername;
        $type="youtube";
        $sql->execute();
        $socialUsername=$fbUsername;
        $type="facebook";
        if($sql->execute()){
            $status="success";
            $message="Social username updated";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong";
            $genMsg=sendResponse($status, $message);
        }            
    }
}


if (isset($_POST['onautowith'])) {
    if (!empty($_POST['miniautowith'])) {
        $miniautowith = $_POST['miniautowith'];
    }

    $enableautowithdrawa = isset($_POST['autowithdrawa']) ? 1 : 0;

    if (empty($_POST['miniautowith'])) {
        $status = "error";
        $message = "Enter amount";
        $genMsg = sendResponse($status, $message);
    } else {
        $sql = $link->prepare("SELECT * FROM profilelinks WHERE username = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();
        $numrow = $result->num_rows;

        if ($numrow == 0) {
            $sql = $link->prepare("INSERT INTO profilelinks (username, autowithdrawa, miniautowith, date) VALUES (?, ?, ?, ?)");
            $date = date('Y-m-d H:i:s'); // Assuming date is current datetime
            $sql->bind_param("siss", $username, $enableautowithdrawa, $miniautowith, $date);
        } else {
            $sql = $link->prepare("UPDATE profilelinks SET autowithdrawa = ?, miniautowith = ? WHERE username = ?");
            $sql->bind_param("sis", $enableautowithdrawa, $miniautowith, $username);
        }

        if ($sql->execute()) {
            $sql = $link->prepare("SELECT * FROM sitedetails");
            $sql->execute();
$result=$sql->get_result();
$numrow=$result->num_rows;
$row=$result->fetch_assoc();
$activityautoWithdraw = "";
if($numrow == 1){ 
            $activityautoWithdraw = (int)$row['mainwithdraw'];
}

            if ($enableautowithdrawa) {
                if ($funds < $minActWithdrawAmt) {
                    $status = "error";
                    $message = "Minimum activity withdrawal is $minActWithdrawAmt";
                    $genMsg = sendResponse($status, $message);
                } else {
                    if ($activityautoWithdraw) {
                        $deduct_sql = $link->prepare("UPDATE users SET funds = funds - ? WHERE username = ?");
                        $deduct_sql->bind_param("ds", $minActWithdrawAmt, $username);

                        if ($deduct_sql->execute()) {
                            $dateTime = date('Y-m-d H:i:s'); // Current datetime
                            $status = "pending"; // Initial status
                            $wallet = "activity"; // Wallet type
                            $acctPlan = "plan_a"; // Assuming a plan type, modify as needed
                            $description = "Automatic withdrawal";

                            $insert_sql = $link->prepare("INSERT INTO withdrawals (username, type, amount, description, status, number, plan, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $insert_sql->bind_param("ssdsssss", $username, $wallet, $minActWithdrawAmt, $description, $status, $minActWithdrawAmt, $acctPlan, $dateTime);

                            if ($insert_sql->execute()) {
                                $status = "success";
                                $message = "Automatic withdrawal processed successfully";
                                $genMsg = sendResponse($status, $message);
                            } else {
                                $status = "error";
                                $message = "Failed to insert withdrawal record";
                                $genMsg = sendResponse($status, $message);
                            }
                        } else {
                            $status = "error";
                            $message = "Failed to deduct the withdrawal amount";
                            $genMsg = sendResponse($status, $message);
                        }
                    } else {
                        $status = "error";
                        $message = "Automatic withdrawal is currently not available";
                        $genMsg = sendResponse($status, $message);
                    }
                }
            } else {
                $status = "success";
                $message = "Automatic withdrawal not enabled";
                $genMsg = sendResponse($status, $message);
            }
        } else {
            $status = "error";
            $message = "Failed to update profile links";
            $genMsg = sendResponse($status, $message);
        }
    }
} 







if (isset($_POST['tiktokpay'])) {

    if (!empty($_POST['tiktokname'])) {
        $tiktokname = $_POST['tiktokname'];
    }
    if (!empty($_POST['views'])) {
        $views = $_POST['views'];
    }
    if (!empty($_POST['post_link'])) {
        $post_link = $_POST['post_link'];
    }

    // Validate inputs
    if (empty($tiktokname)) {
        $status = "error";
        $message = "Select your TikTok Username"; 
        $genMsg = sendResponse($status, $message);
    } elseif (empty($views)) {
        $status = "error";
        $message = "Enter your Views amount";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($post_link)) {
        $status = "error";
        $message = "Enter your Post Link";
        $genMsg = sendResponse($status, $message);
    } else {
        $tiktokname = filter_string($_POST['tiktokname']);
        $views = filter_string($_POST['views']);
        $post_link = filter_string($_POST['post_link']);

        // Generate a reference and prepare to insert data
        $reference = get_rand_alphanumeric(20);
        $status = "pending";
        $dateTime = date('Y-m-d H:i:s'); // Assuming you want to record the date and time of the request

        // Prepare SQL query
        $sql = $link->prepare("INSERT INTO tiktok_requests (username, tiktokname, views, post_link,status,reference, date) VALUES (?, ?, ?, ?,?, ?, ?)");
        $sql->bind_param("ssissss", $username, $tiktokname, $views, $post_link, $status,$reference,$dateTime);

        // Execute and check result
        if ($sql->execute()) {
            $status = "success";
            $message = "TikTok request has been sent successfully. Your account will be credited shortly when confirmed by our team.";
            $genMsg = sendResponse($status, $message);
        } else {
            $status = "error";
            $message = "Failed to send request";
            $genMsg = sendResponse($status, $message);
        }
    }
}








?>