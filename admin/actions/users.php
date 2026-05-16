<?php
$genMsg="";

if(isset($_POST['makeVendor'])){
    if(empty($_POST['username'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $username=filter_string($_POST['username']);
        $sql=$link->prepare("UPDATE users SET role='vendor' WHERE username=?");
        $sql->bind_param("s", $username);
        if($sql->execute()){
            $status="success";
            $message="User changed to vendor $username"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}

if(isset($_POST['removeVendor'])){
    if(empty($_POST['username'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $username=filter_string($_POST['username']);
        $sql=$link->prepare("UPDATE users SET role='user' WHERE username=?");
        $sql->bind_param("s", $username);
        if($sql->execute()){
            $status="success";
            $message="Vendor removed"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}

if(isset($_POST['suspendUser'])){
    if(empty($_POST['username'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $username=filter_string($_POST['username']);
        $sql=$link->prepare("UPDATE users SET status='suspended' WHERE username=?");
        $sql->bind_param("s", $username);
        if($sql->execute()){
            $status="success";
            $message="User <b>$username</b> has been suspended"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}


if(isset($_POST['activate'])){
    if(empty($_POST['username'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $username=filter_string($_POST['username']);
        $sql=$link->prepare("UPDATE users SET status='active' WHERE username=?");
        $sql->bind_param("s", $username);
        if($sql->execute()){
            $status="success";
            $message="User activated"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}

if(isset($_POST['sendCoupon'])){
    if(empty($_POST['username'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $username=filter_string($_POST['username']);
        $coupon=strtoupper(get_rand_alphanumeric(12));
        $sql=$link->prepare("INSERT INTO coupons(coupon,vendor,date) VALUES(?,?,?)");
        $sql->bind_param("sss", $coupon, $username, $dateTime);
        if($sql->execute()){
            $status="success";
            $message="Coupon sent to $username coupon: <strong>$coupon</strong>"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}


if(isset($_POST['deleteCoupon'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Coupon ID empty"; 
        $genMsg=sendResponse($status, $message);
    }
    if(empty($_POST['username'])){
        $status="error";
        $message="User empty"; 
        $genMsg=sendResponse($status, $message);
    }
    if(empty($_POST['coupon'])){
        $status="error";
        $message="Coupon empty"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $id=filter_string($_POST['id']);
        $username=filter_string($_POST['username']);
        $coupon=filter_string($_POST['coupon']);
        $sql=$link->prepare("SELECT * FROM users WHERE username=? AND coupon=?");
        $sql->bind_param("ss", $username, $coupon);
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        if($numrow == 1){
            $sql=$link->prepare("DELETE FROM users WHERE username=? AND coupon=?");
            $sql->bind_param("ss", $username, $coupon);
            if($sql->execute()){
                $sql=$link->prepare("DELETE FROM coupons WHERE id=?");
                $sql->bind_param("s", $id);
                if($sql->execute()){
                    $status="success";
                    $message="Code and user deleted"; 
                    $genMsg=sendResponse($status, $message);
                }
                else{
                    $status="error";
                    $message="Something went wrong 01"; 
                    $genMsg=sendResponse($status, $message);
                }
            }
            else{
                $status="error";
                $message="Something went wrong 02"; 
                $genMsg=sendResponse($status, $message);
            }
        }
        else{
            $sql=$link->prepare("DELETE FROM coupons WHERE id=?");
            $sql->bind_param("s", $id);
            if($sql->execute()){
                $status="success";
                $message="Code deleted"; 
                $genMsg=sendResponse($status, $message);
            }
            else{
                $status="error";
                $message="Something went wrong 03"; 
                $genMsg=sendResponse($status, $message);
            }
        }
    }
}


if (isset($_POST['deleteVendorCoupons'])) {
    if (empty($_POST['vendor'])) {
        $status = "error";
        $message = "Vendor name empty";
        $genMsg = sendResponse($status, $message);
    } else {
        $vendor = filter_string($_POST['vendor']);

        // select all coupons sold by the vendor
        $sql = $link->prepare("SELECT id, coupon FROM coupons WHERE vendor = ?");
        $sql->bind_param("s", $vendor);
        $sql->execute();
        $result = $sql->get_result();
        
        // loop through each coupon and delete the users that used it
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $coupon = $row['coupon'];
            
            // select users that used the coupon
            $sql2 = $link->prepare("SELECT * FROM users WHERE coupon = ?");
            $sql2->bind_param("s", $coupon);
            $sql2->execute();
            $result2 = $sql2->get_result();
            $numrow = $result2->num_rows;

            // delete the users that used the coupon
            if ($numrow > 0) {
                $sql3 = $link->prepare("DELETE FROM users WHERE coupon = ?");
                $sql3->bind_param("s", $coupon);
                if ($sql3->execute()) {
                    // delete the coupon
                    $sql4 = $link->prepare("DELETE FROM coupons WHERE id = ?");
                    $sql4->bind_param("i", $id);
                    if ($sql4->execute()) {
                        $status = "success";
                        $message = "Users and coupon deleted for $vendor coupons";
                        $genMsg = sendResponse($status, $message);
                    } else {
                        $status = "error";
                        $message = "Something went wrong 02";
                        $genMsg = sendResponse($status, $message);
                    }
                } else {
                    $status = "error";
                    $message = "Something went wrong 01";
                    $genMsg = sendResponse($status, $message);
                }
            }
        }
    }
}



if(isset($_POST['generateCoupon'])){
    if(empty($_POST['vendor'])){
        $status="error";
        $message="Select a vendor"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['plan'])){
        $status="error";
        $message="Select a plan"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['countryname'])){
        $status="error";
        $message="Select a country"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['couponNum'])){
        $status="error";
        $message="Enter coupon quantity"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['couponNum']) || $_POST['couponNum'] <= 0){
        $status="error";
        $message="Enter a valid coupon number greater than 0"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $vendor=filter_string($_POST['vendor']);
        $plan=filter_string($_POST['plan']);
        $countryname = filter_string($_POST['countryname']);
        $couponNum=filter_string($_POST['couponNum']);
        $prefix = isset($_POST['prefix']) ? filter_string($_POST['prefix']) : ''; 
        
        switch($plan){
            case "plan_a" : $suff="BASIC"; break; 
            case "plan_b" : $suff="ELITE"; break; 
            case "plan_c" : $suff="PRO"; break; 
            
        }
        
        $coupons="";
        for($i=1; $i <= $couponNum; $i++){
            $coupon = $prefix . $suff . strtoupper(get_rand_alphanumeric(12));
            $sql = $link->prepare("INSERT INTO coupons(coupon,vendor,countryname,type,date) VALUES(?,?,?,?,NOW())");
            $sql->bind_param("ssss", $coupon, $vendor, $countryname, $plan);
            $sql->execute();
            $coupons .= "$coupon <br>";
        }
        $status="success";
        $message="$plan Coupons generated. Coupons:<br><strong>$coupons</strong>"; 
        $genMsg=sendResponse($status, $message);
    }
}


if(isset($_POST['sendData'])){
    if(empty($_POST['username'])){
        $status="error";
        $message="Enter username"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['dataAmount'])){
        $status="error";
        $message="Enter amount"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $username=filter_string($_POST['username']);
        $sql=$link->prepare("SELECT * FROM users WHERE username=?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        if($numrow == 1){
            $dataAmount=filter_string($_POST['dataAmount']);
            $sql=$link->prepare("UPDATE users SET datafunds=datafunds + ? WHERE username=?");
            $sql->bind_param("ss", $dataAmount, $username);
            if($sql->execute()){
                $status="success";
                $message="$dataAmount MB worth of data sent to $username"; 
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
            $message="User not found"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}
?>