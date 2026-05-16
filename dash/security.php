<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/account-settings.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/password.php";

$ptitle="Update your password";

$enableautowithdrawa = "";
if($autowithdrawa == 1){
    $enableautowithdrawa = "checked";
}
include "inc/header2.php" ?>


 <div class="pc-container">
    <div class="pc-content">
        <?php echo $genMsg ?>

        <section class="section-b-space">
            <div class="custom-container">
                <form class="auth-form pt-0 mt-3" id="formAccountSettings" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="currPsw" class="form-label">Current Password</label>
                        <div class="form-input">
                            <input type="password" class="form-control" name="currPsw" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newPsw" class="form-label">New Password</label>
                        <div class="form-input">
                            <input type="password" class="form-control" name="newPsw" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPsw" class="form-label">Confirm New Password</label>
                        <div class="form-input">
                            <input type="password" class="form-control" name="confirmPsw" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                        </div>
                    </div>
                    <div class="form-group">
                        <h6>Password Requirements:</h6>
                        <ul class="ps-3 mb-0">
                            <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                            <li class="mb-1">At least one lowercase character</li>
                            <li>At least one number, symbol, or whitespace character</li>
                        </ul>
                    </div>
                    <button type="submit" style="background:#f65365; border: 0px; color: white" class="btn btn-main btn-lg w-100 pill p-3" name="updatePsw" id="btn-confirm">Reset Password</button>
                </form>
            </div>
        </section>
    </div>
</div>



    <?php include "inc/footer2.php" ?>