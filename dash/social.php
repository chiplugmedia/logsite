<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
$facebook=$instagram=$twitter=$whatsapp="";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/account-settings.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/password.php";
//$facebook=$instagram=$twitter=$whatsapp="";
$ptitle="Social Settings";
include "inc/eader21.php" ?>


<div class="page-content-wrapper py-3">
    <div class="container">        
<?php echo $genMsg?>


<section class="section-b-space">
    <div class="custom-container">
                

      <form class="auth-form pt-0 mt-3" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
          <label for="facebook" class="form-label">Facebook Link</label>
          <div class="form-input">
            <input type="link" class="form-control" name="facebook" value="<?php echo $facebook?>" placeholder="https://facebook.com/-----">
          </div>
        </div>
        
        <div class="form-group">
          <label for="twitter" class="form-label">Twitter Link</label>
          <div class="form-input">
            <input type="link" class="form-control" name="twitter" value="<?php echo $twitter?>" placeholder="https://twitter.com/-----">
          </div>
          </div>

          <div class="form-group">
          <label for="instagram" class="form-label">Instagram Link</label>
          <div class="form-input">
            <input type="link" class="form-control" name="instagram" value="<?php echo $instagram?>" placeholder="https://instagram.com/-------" />
          </div>
          </div>
          
           <div class="form-group">
          <label for="whatsapp" class="form-label">Whatsapp Number</label>
          <div class="form-input">
            <input type="tel" class="form-control" name="whatsapp" value="<?php echo $whatsapp?>" placeholder="07098787656" />
           </div>
            </div>
            <div class="form-group">
              <h6>Social Requirements:</h6>
              <ul class="ps-3 mb-0">
                <li class="mb-1">Your link must be correct when checked by our team</li>
                <li class="mb-1">All links must correspond ie https://social.com/Username </li>
                <li>Your whatsapp number must be active.</li>
              </ul>
            </div>
          
        <button type="submit" name="updateProfileLinks" class="btn theme-btn w-100">Update</button>
      </form>
    </div>
  </section>
    
   
    <?php include "inc/footer2.php" ?>