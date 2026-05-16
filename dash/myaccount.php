<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/account-settings.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/password.php";




// Fetch indreferralFunds
$sql = $link->prepare("SELECT * FROM users WHERE username = ?");
$sql->bind_param('s', $username);
$sql->execute();
$result = $sql->get_result();
$countryname = ""; // Initialize the variable
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $countryname = $row['countryname']; // Assign the value
} else {
    // Handle the case where no rows are found
    // You may want to set a default value or show an error message
}



$ptitle="Account Settings";
include "inc/eader21.php" ?>


<!-- Content -->




<section class="section-b-space">
    <div class="custom-container">
        <div class="profile-section">
            <div class="profile-banner">
                <div class="profile-image">
                    <?php if ($profileImg == "no-avatar.png") { ?>
                    <img class="img-fluid profile-pic" src="/Flowtrex/user/5.gif" alt="p3">
                     <?php } else { ?>
                    <img class="img-fluid profile-pic" src="assets/img/profilephotos/<?php echo $profileImg ?>" alt="p3">
                     <?php } ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera camera">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </div>
            </div>
            <h2><?php echo $fullname ?></h2>
            <h5><?php echo $email ?></h5>
        </div>
         <?php echo $genMsg?>
        <form method="POST" enctype="multipart/form-data" class="auth-form pt-0 mt-3">
            
            <div class="form-group">
          <label for="upload" class="form-label">Upload new photo</label>
          <div class="form-input">
            <input type="file" id="upload"class="form-control" name="image" placeholder="Enter Your photo">
          </div>
        </div>
        
            <div class="form-group">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullname" value="<?php echo $fullname ?>" placeholder="Enter your fullname">
            </div>

            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <div class="form-input">
                    <input type="text" class="form-control" value="<?php echo $username ?>" readonly name="username" >
                </div>
            </div>
           
          <div class="form-group">
                <label for="email" class="form-label">E-mail</label>
                <div class="form-input">
                    <input type="email" class="form-control" value="<?php echo $email ?>" readonly name="email" >
                </div>
            </div>
           
           <div class="form-group">
                <label for="Country" class="form-label">Country</label>
                <div class="form-input">
                    <input type="text" class="form-control" value="<?php echo $countryname ?>" readonly name="country" placeholder="Enter Your country">
                </div>
            </div>
           
           <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <div class="form-input">
                    <input type="tel" class="form-control" value="<?php echo $phoneNumber?>"  name="phone" placeholder="+234or+233">
                </div>
            </div>
           
            <button type="submit" name="saveProfile" class="btn theme-btn w-100">Update</button>
            </div>
        </form>
    </div>
</section>




  




    <?php include "inc/footer2.php" ?>