<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/actions/formprocess.php";

$ptitle="Login";
include "includes/authhead2.php";
?>
  <p class="mb-4"><?php echo $genMsg?></p>
          <div class="auth-main">
        <div class="auth-wrapper v2">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body" style="background-color: #fefff0; padding: 20px; border-radius: 15px;">

                        <div class="text-center">
                            <a href="/">
                                <img src="/young/Pinatexlogs.png" alt="logo" width="150" height="auto">

                            </a>
                            <form method="POST" action="" class="verify-gcaptcha">
                                <h5 class="my-3">Welcome back to <?php echo htmlspecialchars($sitename); ?></h5>
                               
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <div class="position-relative">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" id="email" name="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Enter your username" autofocus>
                                            </div>
                                            <div class="mb-3 position-relative">
                                                <input type="password" id="psw-input" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password">
                                                <div class="position-absolute" id="password-visibility" style="right: 10px; top: 10px; cursor: pointer;">
                                                    <i class="bi bi-eye" onclick="togglePasswordVisibility()"></i>
                                                    <i class="bi bi-eye-slash" style="display: none;" onclick="togglePasswordVisibility()"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mt-1 justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" name="remember_me" checked>
                                        <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                                    </div>
                                    <h6 class="text-secondary f-w-400 mb-0">
                                        <a href="forgot-password.php" style="color: #28bf62;" >Forgot Password?</a>
                                    </h6>
                                </div>
                               <div class="d-grid mt-4">
    <button name="login" type="submit" style="display: block; text-align: center;"class="buy-btn">
        <i class="fas fa-sign-in-alt fa-lg"></i> Login
    </button>
</div>
                            </form>
                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <h6 class="f-w-500 mb-0">Don't have an Account?</h6>
                                <a style="color: #28bf62;" href="signup.php" class="">Create Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("psw-input");
            var eyeIcon = document.querySelector("#password-visibility .bi-eye");
            var eyeSlashIcon = document.querySelector("#password-visibility .bi-eye-slash");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.style.display = "none";
                eyeSlashIcon.style.display = "inline";
            } else {
                passwordInput.type = "password";
                eyeIcon.style.display = "inline";
                eyeSlashIcon.style.display = "none";
            }
        }
    </script>

    <!-- Bootstrap JS (optional for responsive and interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

 <?php include "includes/authfoot2.php" ?>