<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

if($role != "vendor"){
    header("location:$stream/dash/");
    exit;
}

$sql=$link->prepare("SELECT * FROM coupons WHERE vendor=?");
$sql->bind_param("s", $username);
$sql->execute();
$result=$sql->get_result();
$totalCoupon=$result->num_rows;

$sql=$link->prepare("SELECT * FROM coupons WHERE vendor=? AND status='used' ");
$sql->bind_param("s", $username);
$sql->execute();
$result=$sql->get_result();
$usedCoupon=$result->num_rows;

$sql=$link->prepare("SELECT * FROM coupons WHERE vendor=? AND status='active' ");
$sql->bind_param("s", $username);
$sql->execute();
$result=$sql->get_result();
$unUsedCoupon=$result->num_rows;
include "actions/currency_rates.php" ;


$ptitle="Coupon codes";
include "inc/header2.php" ?>


<section class="section-b-space">
    <div class="custom-container">
        <div class="profile-title" style="display: flex; align-items: center; margin-bottom: 20px;">
            <?php if ($profileImg == "no-avatar.png") { ?>
                <img class="img-fluid profile-pic" src="/Flowtrex/user/5.gif" alt="Avatar" width="40">
            <?php } else { ?>
                <img class="img-fluid profile-pic" src="assets/img/profilephotos/<?php echo $profileImg?>" alt="Avatar" width="40">
            <?php } ?>
            <div style="display: flex; flex-direction: column; margin-left: 10px;">
                <h2 class="dark-text" style="display: flex; align-items: center;">Hi, <?php echo $fullname; ?><img class="ml-2" src="img/hand.gif" alt="hand-gif" width="32"></h2>
                <h5 style="color: orange;"><?php echo $greeting; ?></h5>
            </div>
        </div>
        
      <div class="card-box">
        <div class="card-details">
          <div class="d-flex justify-content-between">
            <h5 class="fw-semibold">Total Balance</h5>
          </div>

          <h1 class="mt-2 text-white"><?php echo $totalCoupon?></h1>

          <div class="amount-details">
            <div class="amount w-50 text-start">
              <div class="d-flex align-items-center justify-content-start">
                <h5>Used Codes</h5>
              </div>
              <h1 class="text-white"><?php echo $usedCoupon?></h1>
            </div>
            <div class="amount w-50 text-end border-0">
              <div class="d-flex align-items-center justify-content-end">
                <h5>UnUsed Codes</h5>
              </div>
              <h1 class="text-white"><?php echo $unUsedCoupon?></h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    
    
  
    
<div class="card-header">
  <h6></h6>
  <!-- Responsive Table -->
  <div class="pt-3"></div>
  <div class="container direction-rtl">
    <div class="transaction-box">
      <div class="transaction-box">
        <div class="table-responsive text-nowrap">
          <div class="box-header with-border">
            <div class="mt-2">
              <h6 class="dark-text"><?php echo $ptitle ?></h6>
              <p><span class="badge badge-primary"></span></p>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-lg table-striped invoice-archive">
                <thead>
                  <tr>
                    <th class="dark-text">Rank</th>
                    <th class="dark-text">Coupon</th>
                    <th class="dark-text">Country</th>
                    <th class="dark-text">Status</th>
                    <th class="dark-text">Generated Date</th>
                    <th class="dark-text">Used By</th>
                    <th class="dark-text">Copy Coupon Code</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = $link->prepare("SELECT * FROM coupons WHERE vendor=? ORDER BY id DESC");
                  $sql->bind_param("s", $username);
                  $sql->execute();
                  $result = $sql->get_result();
                  $numrow = $result->num_rows;

                  if ($numrow > 0) {
                      $id = 0;
                      while ($row = $result->fetch_assoc()) {
                          $id++;
                          $countryname = $row['countryname'];
                          $coupon = $row['coupon'];
                          $date = $row['date'];
                          $status = $row['status'];

                          $statusColor = $status == "used" ? "value text-danger" : "value text-success";

                          $sql_user = $link->prepare("SELECT * FROM users WHERE coupon=?");
                          $sql_user->bind_param("s", $coupon);
                          $sql_user->execute();
                          $result_user = $sql_user->get_result();
                          $row_user = $result_user->fetch_assoc();
                          $numrow_user = $result_user->num_rows;
                          $usedBy = $numrow_user == 1 ? $row_user['username'] : "";
                          $image = $numrow_user == 1 ? $row_user['image'] : "";
                          ?>
                          <tr>
                            <td><span class="badge bg-primary"><?php echo $id ?></span></td>
                            <td><h6 class="dark-text"><?php echo $coupon ?></h6></td>
                            <td><h6 class="dark-text"><?php echo $countryname ?></h6></td>
                            <td><button type="button" class="btn <?php echo $statusColor ?> btn-sm p-1" target="_blank"><?php echo $status ?></button></td>
                            <td><h6 class="dark-text"><?php echo $date ?></h6></td>
                                          <?php if ($image == "no-avatar.png") { ?>

                            <td class="dark-text d-flex me-3 align-items-center"><img src="/Flowtrex/user/5.gif" width="40" alt="Avatar" class="rounded-circle mr-3"> <?php echo $usedBy ?></td>
                             <?php } else { ?>
                            <td class="dark-text d-flex me-3 align-items-center"><img src="assets/img/profilephotos/<?php echo $image ?>" width="40" alt="Avatar" class="rounded-circle mr-3"> <?php echo $usedBy ?></td>
                              <?php } ?>
                            <td><button type="button" class="copy-btn copy-coupon" data-coupon="<?php echo $coupon ?>">Copy</button></td>
                          </tr>
                          <?php
                      }
                  } else {
                      echo "<tr><td colspan='7'>No Coupon Code found.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const copyButtons = document.querySelectorAll('.copy-coupon');
    copyButtons.forEach(button => {
      button.addEventListener('click', function() {
        const couponCode = this.getAttribute('data-coupon');
        navigator.clipboard.writeText(couponCode)
          .then(() => {
            alert('Coupon copied to clipboard: ' + couponCode);
          })
          .catch(err => {
            console.error('Failed to copy coupon: ', err);
          });
      });
    });
  });
</script>
 <style>
    .copy-btn {
        float: right;
        background-color: #fb7502;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .copy-btn:hover {
        background-color: darkgoldenrod;
    }

    .hidden {
        display: none;
    }
</style>

<?php include "inc/footer2.php" ?>