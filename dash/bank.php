<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/account-settings.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/password.php";



$ptitle="Payments Settings";
include "inc/eader21.php" ?>

<div class="page-content-wrapper py-3">
    <div class="container">
       
<!-- Content -->
        <strong><?php echo $genMsg?></strong>

<section class="section-b-space">
    <div class="custom-container">
                

      <form class="auth-form pt-0 mt-3" method="post" enctype="multipart/form-data">
        <div class="form-group">
           <label class="form-group" for="currentPassword">Select Bank</label>
                <select class="form-control" name="bankName">
                    <option disabled><?php echo $bankName?></option>
                    <?php
                        $sql=$link->prepare("SELECT * FROM banks");
                        $sql->execute();
                        $result=$sql->get_result();
                        $numrow=$result->num_rows;
                        if($numrow > 0){
                            while($row=$result->fetch_assoc()){
                                $bank=$row['bankname'];
                                $code=$row['bankcode'];
                                $codeBank=$code."_".$bank;
                                $selected="";
                                
                                if($bankCode == $code){
                                    $selected="selected";
                                }
                                echo "<option value='$codeBank' $selected>$bank</option>";
                            }
                        }
                    ?>
                </select>
        </div>

        <div class="form-group">
          <label for="inputusername" class="form-label">Account Number</label>
          <div class="form-input">
            <input type="text" class="form-control" name="acctNum" value="<?php echo $acctNum?>" placeholder="Account Number">
          </div>
        </div>
        
        <div class="form-group">
          <label for="inputusername" class="form-label">Account Name</label>
          <div class="form-input">
            <input type="text" class="form-control" name="acctName" value="<?php echo $acctName?>" placeholder="Account Name">
          </div>
        </div>
       
        <button type="submit" name="saveBank" class="btn theme-btn w-100">Update</button>
      </form>
    </div>
  </section>
  
    <?php include "inc/footer2.php" ?>