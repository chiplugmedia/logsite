<?php
$genMsg = $username = $fullname = $email = $phone = $password = $coupon = $country ="";

if (isset($_POST['login'])) {

    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
    }
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    }

    if (empty($_POST['username'])) {
        $status = "error";
        $message = "Enter your username";
        $genMsg = sendResponse($status, $message);
    } else if (empty($_POST['password'])) {
        $status = "error";
        $message = "Enter your password";
        $genMsg = sendResponse($status, $message);
    } else {
        $psw = sha1($password);
        $sql = $link->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $sql->bind_param("ss", $username, $username);
        $sql->execute();
        $result = $sql->get_result();
        $numrow = $result->num_rows;
        $row = $result->fetch_assoc();
        if ($numrow == 0) {
            $status = "error";
            $message = "Incorrect username or password";
            $genMsg = sendResponse($status, $message);
        } else {
            $hashedPassword = $row['password'];
            $username = $row['username'];
            $role = $row['role'];
            $status = $row['status'];
            $time = $row['time'];
            if (!password_verify($psw, $hashedPassword)) {
                $status = "error";
                $message = "Incorrect username or password";
                $genMsg = sendResponse($status, $message);
            } else if ($status == "suspended" && $role != "user" && $role != "vendor") {
                $status = "error";
                $message = "Your account has been suspended";
                $genMsg = sendResponse($status, $message);
            } else {
                session_regenerate_id();
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                session_write_close();
                
                $genMsg = sendResponse("success", "Login successful!");

                // Redirect user with JS
                if (in_array($role, ['user', 'agent', 'vendor'])) {
                    echo "<script>setTimeout(()=>location.href='$stream/dash', 1500);</script>";
                } elseif ($role === "assistant") {
                    echo "<script>setTimeout(()=>location.href='$stream/assistant/account.php', 1500);</script>";
                } elseif ($role === "admin") {
                    echo "<script>setTimeout(()=>location.href='$stream/admin/dashboard.php', 1500);</script>";
                }
            }
        }
    }
}




if (isset($_POST['signup'])) {
    
    if (!empty($_POST['fullname'])) {
        $fullname = $_POST['fullname'];
    }
    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
    }
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (!empty($_POST['phoneNumber'])) {
        $phone = $_POST['phoneNumber'];
    }
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    }
    if (!empty($_POST['refUsername'])) {
        $refUsername = $_POST['refUsername'];
    }

    if(empty($_POST['fullname'])){
        $status="error";
        $message="Enter your fullname"; 
        $genMsg=sendResponse($status, $message);
    }
    if (empty($_POST['username'])) {
        $status = "error";
        $message = "Enter a username";
        $genMsg = sendResponse($status, $message);
    } else if (strlen($_POST['username']) > 20) {
        $status = "error";
        $message = "Username should be less than 20 characters";
        $genMsg = sendResponse($status, $message);
    } else if (empty($_POST['email'])) {
        $status = "error";
        $message = "Enter your email address";
        $genMsg = sendResponse($status, $message);
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $status = "error";
        $message = "Enter a valid email address";
        $genMsg = sendResponse($status, $message);
    } else if (empty($_POST['phoneNumber'])) {
        $status = "error";
        $message = "Enter your phone number";
        $genMsg = sendResponse($status, $message);
    } else if (empty($_POST['password'])) {
        $status = "error";
        $message = "Enter a password";
        $genMsg = sendResponse($status, $message);
    } else if (strlen($_POST['password']) < 8) {
        $status = "error";
        $message = "Password must be at least 8 characters";
        $genMsg = sendResponse($status, $message);
    } else {
        $fullname=filter_string($_POST['fullname']);
        $username = filter_string($_POST['username']);
        $email = filter_string($_POST['email']);
        $phoneNumber = filter_string($_POST['phoneNumber']);
        $password = filter_string($_POST['password']);

        $sql = $link->prepare("SELECT * FROM users WHERE username=?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_user = $result->num_rows;

        $sql = $link->prepare("SELECT * FROM users WHERE email=?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_email = $result->num_rows;

        $sql = $link->prepare("SELECT * FROM users WHERE phone=?");
        $sql->bind_param("s", $phoneNumber);
        $sql->execute();
        $result = $sql->get_result();
        $numrow_phone = $result->num_rows;

        if ($numrow_user > 0) {
            $status = "error";
            $message = "Username already exists";
            $genMsg = sendResponse($status, $message);
        } else if ($numrow_email > 0) {
            $status = "error";
            $message = "Email already exists";
            $genMsg = sendResponse($status, $message);
        } else if ($numrow_phone > 0) {
            $status = "error";
            $message = "Phone number already in use";
            $genMsg = sendResponse($status, $message);
        } else {
   $hashedPassword = sha1($password);
$hashedPassword = password_hash($hashedPassword, PASSWORD_DEFAULT);
$numrow_refUser = 1;
$addRef = true;

if ($numrow_refUser == 0) {
    $status = "error";
    $message = "Invalid referral";
    $genMsg = sendResponse($status, $message);
} else {
    // Add the direct referral
    $sql = $link->prepare("INSERT INTO referrals (username, referral, date) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $username, $refUsername, $dateTime);
    $sql->execute();
}


    // Insert user details with verification token and set as not verified
    $sql = $link->prepare("INSERT INTO users (fullname, username, email, phone, password, date, time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssssss", $fullname, $username, $email, $phoneNumber, $hashedPassword, $dateTime, $time);
    $sql->execute();

    $message="Welcome";
    $subject="Welcome to $sitename";
    $type="welcomeMail";
     sendMail($email, $fullname, $message, $subject, $type);

    if ($sql->affected_rows > 0) {
        $status = "success";
        $message = "Registration successful";
        $genMsg = sendResponse($status, $message);
        echo "<script>setTimeout(()=>location.href='$stream/login.php', 3000);</script>";
    } else {
        $status = "error";
        $message = "Something went wrong creating account";
        $genMsg = sendResponse($status, $message);
    }
}
}
    }
 







    


    

if (isset($_POST['forgotPsw'])) {
    if (empty($_POST['email'])) {
        $status = "error";
        $message = "Enter your email address";
        $genMsg = sendResponse($status, $message);
    } else {
        $email = filter_string($_POST['email']);

        $sql = $link->prepare("SELECT * FROM users WHERE email=?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        $numrow = $result->num_rows;
        $row = $result->fetch_assoc();
        if ($numrow == 1) {
            $fullname = $row['fullname'];
            $token = get_rand_alphanumeric(20);
            $sql = $link->prepare("DELETE FROM otp WHERE email=?");
            $sql->bind_param("s", $email);
            if ($sql->execute()) {
                $sql = $link->prepare("INSERT INTO otp(email, otp, date) VALUES(?,?,?)");
                $sql->bind_param("sss", $email, $token, $dateTime);
                $sql->execute();

                $subject = "Password Reset";
                $message = array("fullname" => $fullname, "pswToken" => $token);
                $type = "forgotPsw";

                $mail = sendMail($email, $fullname, $message, $subject, $type);
                $mailStatus = $mail['status'];
                $mailMessage = $mail['message'];
                if ($mailStatus == "success") {
                    $status = "success";
                    $message = "Password reset link sent successfully. Please check your email and follow the procedures";
                    $genMsg = sendResponse($status, $message);
                } else {
                    $status = "error";
                    $message = "Something went wrong resetting the password, please try again";
                    $genMsg = sendResponse($status, $message);
                }
            } else {
                $status = "error";
                $message = "Something went wrong";
                $genMsg = sendResponse($status, $message);
            }
        } else {
            $status = "error";
            $message = "Invalid email address";
            $genMsg = sendResponse($status, $message);
        }
    }
}




if (isset($_POST['resetPsw'])) {
    if (empty($_POST['password'])) {
        $status = "error";
        $message = "Enter your new password";
        $genMsg = sendResponse($status, $message);
    } else if (strlen($_POST['password']) < 8) {
        $status = "error";
        $message = "Password must be at least 8 characters";
        $genMsg = sendResponse($status, $message);
    } else if (empty($_POST['confirmPsw'])) {
        $status = "error";
        $message = "Retype your new password";
        $genMsg = sendResponse($status, $message);
    } else if ($_POST['password'] != $_POST['confirmPsw']) {
        $status = "error";
        $message = "Passwords do not match";
        $genMsg = sendResponse($status, $message);
    } else {
        $password = filter_string($_POST['password']);
        $password = sha1($password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $email = filter_string($_SESSION['forgotEmail']);

        $sql = $link->prepare("UPDATE users SET password=? WHERE email=?");
        $sql->bind_param("ss", $password, $email);
        if ($sql->execute()) {
            $sql = $link->prepare("DELETE FROM otp WHERE email=?");
            $sql->bind_param("s", $email);
            $sql->execute();

            header("location:login.php");
        } else {
            $status = "error";
            $message = "Failed to update the password";
            $genMsg = sendResponse($status, $message);
        }
    }
}
       


?>

 
