<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/account-settings.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/password.php";

$ptitle="Account Settings";
include "inc/header2.php" ?>



    <div class="pc-container">
        <div class="pc-content">

            <div class="col-xl-12 col-sm-12">


               <div class="response"><?php echo $genMsg?></div>
<div class="row">
    
    
    <div class="grid grid-cols-12 gap-5">
                    
                    
                    <div class="lg:col-span-8 col-span-12">
                        <div class="card">
                            <header class="card-header noborder">
                                <h4 class="card-title">Personal Details</h4>
                            </header>
                            <center>
                                <div class="">
                                    <div class="h-20 w-20 rounded-full">
                                       <?php
$width = "100px"; // Set the desired width
$height = "100px"; // Set the desired height

if ($profileImg == "no-avatar.png") {
    echo '<img src="/young/7.jpg" alt="" style="border-radius: 500px; width: ' . $width . '; height: ' . $height . ';" class="rounded-circle header-profile-user">';
} else {
    echo '<img src="assets/img/profilephotos/' . $profileImg . '" alt="" style="border-radius: 500px; width: ' . $width . '; height: ' . $height . ';" class="rounded-circle header-profile-user">';
}
?>

                                    
                                    </div>
                                </div>
                            </center>
                            <div class="card-body p-6">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="mt-4">
                                        <label for="defaultFormControlInput" class="form-label">Fullname</label>
                                       <input class="form-control" id="first_name" value="<?php echo $fullname?>" name="fullname" type="text" placeholder="Enter your full name">
                                    </div>
                                  <div class="mt-4">
                                        <label for="defaultFormControlInput" class="form-label">Profile Pic</label>
                                       <input class="form-control" id="upload"  name="image" accept="image/*" type="file">
                                    </div>
                                    <div class="mt-4">
                                        <label for="defaultFormControlInput" class="form-label">Username</label>
                                       <input class="form-control" type="text" value="<?php echo $username?>" placeholder="Also your last name" readonly="">
                                    </div>
                                    <div class="mt-4">
                                        <label for="defaultFormControlInput" class="form-label">Email</label>
                                       <input class="form-control" type="email" value="<?php echo $email?>" placeholder="name@company.com" readonly="">
                                    </div>
                                    <div class="mt-4">
                                        <label for="defaultFormControlInput" class="form-label">Phone Number</label>
                                       <input class="form-control" name="phone" type="text" value="<?php echo $phoneNumber?>" placeholder="+234or+222">
                                    </div>
                                    <div class="mt-4">
                                        <button style="display: block; text-align: center;"class="buy-btn w-100" type="submit" name="saveProfile" >Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    
                  
        
        <div class="lg:col-span-8 col-span-12">
    <div class="card">
        <header class="card-header noborder">
            <h4 class="card-title">Password Details</h4>
        </header>
        <div class="card-body p-6">
            <h6>Password Requirements:</h6>
            <ul class="ps-3 mb-0">
                <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                <li class="mb-1">At least one lowercase character</li>
                <li>At least one number, symbol, or whitespace character</li>
            </ul>
            <form method="POST" action="#">
    <div class="mt-4">
        <label for="defaultFormControlInput" class="form-label">Enter current password</label>
        <input type="password" name="currPsw" value="" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="emailHelp">
    </div>
    <div class="mt-4">
        <label for="defaultFormControlInput" class="form-label">Enter new password</label>
        <input type="password" name="newPsw" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" value="" aria-describedby="emailHelp">
    </div>
    <div class="mt-4">
        <label for="defaultFormControlInput" class="form-label">Re-Enter new password</label>
        <input type="password" name="confirmPsw" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" value="" aria-describedby="emailHelp">
    </div>
    <div class="mt-4">
        <button style="display: block; text-align: center;"class="buy-btn w-100"  name="updatePsw">Update Password</button>
    </div>
</form>

        </div>
                        </div>
                    </div>
                </div>
      </div>
                    </div>
                </div>

     <script>
                    $(".deleteImg").on("click", function(){
                        $("form").submit(function(){
                            return false;
                        })
                        let actionType="deleteImg";
                        action(actionType);
                        
                    })
                    
                    function action(action){
                        let form=document.createElement('form');
                        let inputAction=document.createElement('input');
                        let body=document.querySelector('body');
                        form.method="POST";

                        inputAction.type="hidden";
                        inputAction.value=action;
                        inputAction.name=action;

                        form.appendChild(inputAction);
                        body.appendChild(form);
                        form.submit();
                    }
                    
                    
                    
               
                </script>
    
    </div>
    </div>

    <?php include "inc/footer2.php" ?>