<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/actions/formprocess.php";

$ptitle="Forgot Password";
include "includes/authhead2.php";
?>
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
                        <h4 class="mb-3 text-center">Forgot Password? 😢</h4>
                        <h6 class="mb-3 text-center">Enter your email and we'll send you instructions to reset your password</h6>
                        <p><?php echo $genMsg; ?></p>
                        <!-- Register Form -->
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="position-relative">
                                    <div class="mb-3">
                                        <input class="form-control" type="email" value="<?php echo $email; ?>" name="email" placeholder="Enter your email" autofocus>
                                    </div>
                                    <div class="d-grid mt-4">
                                    <button style="display: block; text-align: center;"class="buy-btn" name="forgotPsw" type="submit" ><i class="fas fa-paper-plane fa-lg"></i>Send Reset Link</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- / Content -->

 <?php include "includes/authfoot2.php" ?>