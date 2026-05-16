<?php 
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/actions/formprocess.php";

if(!isset($_GET['tkn']) || empty($_GET['tkn'])){
    header("location:login.php");
    exit;
}
$token=filter_string($_GET['tkn']);
$sql=$link->prepare("SELECT * FROM otp WHERE otp=?");
$sql->bind_param("s", $token);
$sql->execute();
$result=$sql->get_result();
$numrow=$result->num_rows;
$row=$result->fetch_assoc();
if($numrow == 1){
    $email=$_SESSION['forgotEmail']=$row['email'];
}
else{
    header("location:login.php");
    exit;
}

$ptitle="Reset Password";
include "includes/authhead2.php";
?>
  <style>
        /* CSS for the Eye Icon Toggle */
        .cursor-pointer {
            cursor: pointer;
            font-size: 18px; /* Adjust icon size */
            transition: transform 0.2s ease-in-out;
        }

        /* Add hover effect for the eye icon */
        .cursor-pointer:hover {
            transform: scale(1.1);
        }

        /* Optional: You can add styling to the input group */
        .input-group {
            position: relative;
        }

        /* Optional: Style for the input elements */
        .input-group .form-control {
            padding-right: 40px; /* To provide space for the eye icon */
        }
    </style>

    <div class="auth-main">
        <div class="auth-wrapper v2">
            <div class="auth-form">
                <div class="card my-5">
                   <div class="card-body" style="background-color: #fefff0; padding: 20px; border-radius: 15px;">
                        <div class="text-center">
                            <a href="/">
                                <img src="/young/Pinatexlogs.png" alt="logo" width="150" height="auto">
                            </a>
                        </div>
                        <form method="POST" action="" class="verify-gcaptcha">
                            <h4 class="mb-1 pt-2">Reset Password &#x1F4DD;</h4>
                            <p class="mb-4">for <span class="fw-bold"><?php echo $email; ?></span></p>
                            <p class="mb-4"><?php echo $genMsg; ?></p>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="confirm-password">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm-password" class="form-control" name="confirmPsw" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="confirm-password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button style="display: block; text-align: center;"class="buy-btn" name="resetPsw" type="submit">Set new password</button>
                            </div>
                            <div class="text-center">
                                <a href="login">
                                    <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                                    Back to login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Reset Password -->
            </div>
        </div>
    </div>

    <script>
        // JavaScript for password visibility toggle
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelectorAll('.cursor-pointer');
            
            togglePassword.forEach(function (icon) {
                icon.addEventListener('click', function () {
                    const input = this.previousElementSibling;
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.innerHTML = '<i class="ti ti-eye"></i>'; // Change icon to 'eye'
                    } else {
                        input.type = 'password';
                        this.innerHTML = '<i class="ti ti-eye-off"></i>'; // Change icon to 'eye-off'
                    }
                });
            });
        });
    </script>
 <?php include "includes/authfoot2.php" ?>