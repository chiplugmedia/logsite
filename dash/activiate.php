<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/main.php";

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


$ptitle="Activate Account";
include "inc/eader21.php" ?>


<!-- Content -->
        
<div class="page-content-wrapper py-3">
    <div class="container">
       
<!-- Content -->
        <strong><?php echo $genMsg?></strong>

<section class="section-b-space">
    <div class="custom-container">
                <header class="card-header noborder">
                                <h4 class="card-title"><?php echo $ptitle?></h4>
                            </header>

      <form class="auth-form pt-0 mt-3" method="post" enctype="multipart/form-data">
          <div class="form-group">
          <label for="coupon" class="form-label">Enter Coupon Code:</label>
          <div class="form-input">
            <input type="text" class="form-control" id="coupon" name="coupon" value="<?php echo $coupon?>" placeholder="Enter Coupon Code:">
          </div>
         <input type="hidden" class="form-control" id="countryname" name="countryname" value="<?php echo $countryname?>" placeholder="Enter countryname:">

          <div class="auth-forgot-password mt-1">
        <p class="mt-3 mb-0">Dont Have Coupon Code? <a href="/activation-code">Buy Coupon</a></p>
      </div>
 <button type="submit" name="activateAccountWallet" class="btn theme-btn w-100">Activate</button>
      </form>
    </div>
  </section>
  
  
  
<?php include "inc/footer2.php" ?>