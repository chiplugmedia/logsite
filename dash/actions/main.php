<?php
$genMsg = "";
if(isset($_POST['activateAccountWallet'])) {
    if(empty($_POST['coupon'])) {
        $status = "error";
        $message = "Enter coupon code";
        $genMsg = sendResponse($status, $message);
    } else if(empty($_POST['countryname'])) {
        $status = "error";
        $message = "Enter country";
        $genMsg = sendResponse($status, $message);
    } else {
        $coupon = filter_string($_POST['coupon']);
        $countryname = filter_string($_POST['countryname']);

        $sql = $link->prepare("SELECT * FROM coupons WHERE coupon=?");
        $sql->bind_param("s", $coupon);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_coupon = $result->num_rows;

        $sql = $link->prepare("SELECT * FROM coupons WHERE coupon=? AND status='active'");
        $sql->bind_param("s", $coupon);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_couponUsed = $result->num_rows;

        // Check if the coupon code and country are valid together
        $sql = $link->prepare("SELECT * FROM coupons WHERE coupon=? AND countryname=?");
        $sql->bind_param("ss", $coupon, $countryname);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_couponCountry = $result->num_rows; 
        
        if($numrow_coupon == 0) {
            $status = "error";
            $message = "Invalid coupon";
            $genMsg = sendResponse($status, $message);
        } else if($numrow_couponUsed == 0) {
            $status = "error";
            $message = "Coupon has already been used";
            $genMsg = sendResponse($status, $message);
        } else if ($numrow_couponCountry == 0) {
            $status = "error";
            $message = "Coupon code is invalid for the selected country";
            $genMsg = sendResponse($status, $message);   
        } else {
            $time = strtotime("+1 hour", time()); // Changed to 1 hour
            $sql = $link->prepare("UPDATE users SET acctype='standard', time=?, coupon=? WHERE username=?");
            $sql->bind_param("sss", $time, $coupon, $username);
            if($sql->execute()) {
                $sql = $link->prepare("SELECT * FROM activations WHERE username=?");
                $sql->bind_param("s", $username);
                $sql->execute();
                $result = $sql->get_result();
                $numrowActivation = $result->num_rows;

                $welcomeBonus = 200;
                if(!empty($welcomeBonus)) {
                    $message = "You earned cashback from welcome bonus <p class='text-success'> + NP$welcomeBonus</p>";
                    $sql = $link->prepare("INSERT INTO messages(username, message, date) VALUES(?,?,?)");
                    $sql->bind_param("sss", $username, $message, $dateTime);
                    $sql->execute();

                    $sql = $link->prepare("UPDATE users SET funds=funds + ? WHERE username=?");
                    $sql->bind_param("ss", $welcomeBonus, $username);
                    $sql->execute();

                    $type = "Cashback Bonus";
                    $sql = $link->prepare("INSERT INTO userearnings(username, type, amount, time, date) VALUES(?,?,?,?,?)");
                    $sql->bind_param("sssss", $username, $type, $welcomeBonus, $time, $dateTime);
                    $sql->execute();
                }

                $sql = $link->prepare("UPDATE coupons SET status='used' WHERE coupon=?");
                $sql->bind_param("s", $coupon);
                $sql->execute();

                $sql = $link->prepare("INSERT INTO activations(username, amount, date) VALUES(?,?,?)");
                $sql->bind_param("sss", $username, $coupon, $dateTime);
                $sql->execute();

                $acctType = "standard";
                $status = "success";
                $message = "Your account has been activated.";
                $genMsg = sendResponse($status, $message);
            } else {
                $status = "error";
                $message = "Something went wrong";
                $genMsg = sendResponse($status, $message);
            }
        }
    }
}
?>
