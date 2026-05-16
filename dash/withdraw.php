<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/withdraw.php";

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


$ptitle="Request Withdrawal";
include "inc/eader21.php" ?>


<div class="page-content-wrapper py-3">
    <div class="container">

<!-- Withdraw section starts -->
<section class="section-b-space">
  <div class="custom-container">
    <div class="title">
      <h2>Money withdraw from</h2>
    </div>
    <?php echo $genMsg; ?>
    <form method="post" action="">
      <input type="hidden" class="form-control" id="countryname" name="countryname" value="<?php echo $countryname; ?>" placeholder="Country Name" aria-describedby="defaultFormControlHelp" />
        
      <ul class="select-bank">
    <li>
        <div class="balance-box <?php echo (isset($_POST['wallet']) && $_POST['wallet'] == 'referral') ? 'active' : ''; ?>">
            <input class="form-check-input" type="radio" id="mySelectReferral" name="wallet" value="referral" <?php echo (isset($_POST['wallet']) && $_POST['wallet'] == 'referral') ? 'checked' : ''; ?> />
            <img class="img-fluid balance-box-img active" src="/Flowtrex/user/mPay/assets/images/svg/balance-box-bg-active.svg" alt="balance-box" />
            <img class="img-fluid balance-box-img unactive" src="/Flowtrex/user/mPay/assets/images/svg/balance-box-bg.svg" alt="balance-box" />
            <div class="balance-content">
                <h6>Affiliate-Bal</h6>
                <h3><?php echo $dollar . number_format((float)$referralFunds, 2); ?></h3>
                <h5><?php echo $acctNum; ?></h5>
            </div>
        </div>
    </li>
    <li>
        <div class="balance-box <?php echo (isset($_POST['wallet']) && $_POST['wallet'] == 'activity') ? 'active' : ''; ?>">
            <input class="form-check-input" type="radio" id="mySelectActivity" name="wallet" value="activity" <?php echo (isset($_POST['wallet']) && $_POST['wallet'] == 'activity') ? 'checked' : ''; ?> />
            <img class="img-fluid balance-box-img active" src="/Flowtrex/user/mPay/assets/images/svg/balance-box-bg-active.svg" alt="balance-box" />
            <img class="img-fluid balance-box-img unactive" src="/Flowtrex/user/mPay/assets/images/svg/balance-box-bg.svg" alt="balance-box" />
            <div class="balance-content">
                <h6>Activity-Bal</h6>
                <h3><?php echo $point . number_format((float)$funds, 2); ?></h3>
                <h5><?php echo $acctNum; ?></h5>
            </div>
        </div>
    </li>
    <li>
        <div class="balance-box <?php echo (isset($_POST['wallet']) && $_POST['wallet'] == 'social') ? 'active' : ''; ?>">
            <input class="form-check-input" type="radio" id="mySelectSocial" name="wallet" value="social" <?php echo (isset($_POST['wallet']) && $_POST['wallet'] == 'social') ? 'checked' : ''; ?> />
            <img class="img-fluid balance-box-img active" src="/Flowtrex/user/mPay/assets/images/svg/balance-box-bg-active.svg" alt="balance-box" />
            <img class="img-fluid balance-box-img unactive" src="/Flowtrex/user/mPay/assets/images/svg/balance-box-bg.svg" alt="balance-box" />
            <div class="balance-content">
                <h6>Social-Bal</h6>
                <h3><?php echo $point . number_format((float)$score, 2); ?></h3>
                <h5><?php echo $acctNum; ?></h5>
            </div>
        </div>
    </li>
</ul>

      <div class="title"></div>
      <div class="auth-form p-0">
        <div class="form-group">
          <label for="amount" class="form-label">Amount</label>
          <input type="tel" class="form-control" name="amount" value="<?php echo $amount; ?>" placeholder="Enter amount" />
        </div>
        <button type="submit" class="btn theme-btn w-100" name="withdraw">Withdraw</button>
      </div>
    </form>
  </div>
</section>



<div class="col-md-3 col-6">
          <div class="bill-box" style="background-image: url('/Flowtrex/user/mPay/assets/images/background/auth-bg.jpg');">
            <div class="d-flex gap-3">
              
              <div class="bill-details">
                <h5 class="mt-2 text-white balance">Total Withdrawn: <?php echo $dollar?><?php echo number_format((int) $totalWithdrawn, 2) ?></h5>
              </div>
            </div>
            
          </div>
        </div>



<section>
  <div class="custom-container">
    <div class="title">
      <h2>Recent Transaction</h2>
      <a href="transaction">See all</a>
    </div>
  </div>
  <div class="offcanvas-body">
    <div class="standard-tab">
      <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="btn active" id="affiliate-tab" data-bs-toggle="tab" data-bs-target="#affiliate" type="button" role="tab" aria-controls="affiliate" aria-selected="true">Affiliate Withdrawal</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="btn" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false">Activity Withdrawal</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="btn" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">Social Withdrawal</button>
        </li>
      </ul>

      <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">
        <div class="tab-pane fade show active" id="affiliate" role="tabpanel" aria-labelledby="affiliate-tab">
          <?php
          $sql = $link->prepare("SELECT * FROM withdrawals WHERE username=? AND type='referral' ORDER BY id DESC LIMIT 5");
          $sql->bind_param("s", $username);
          $sql->execute();
          $result = $sql->get_result();
          $numrow = $result->num_rows;

          if ($numrow > 0) {
            while ($row = $result->fetch_assoc()) {
              $type = $row['type'];
              $amount = $row['amount'];
              $date = $row['date'];
              $status = $row['status'];

              if ($type == "referral") {
                $typesb = "Affiliate";
                $color = "";
                if ($status == "pending") {
                  $color = "text-warning";
                } elseif ($status == "rejected") {
                  $color = "text-danger";
                } elseif ($status == "successful") {
                  $color = "value text-success";
                }
                $symbol = "₦";
                ?>
                <div class="row gy-3">
                  <div class="col-12">
                    <div class="transaction-box">
                      <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
                        <div class="transaction-image">
                          <img class="img-fluid transaction-icon" src="/Flowtrex/user/mPay/assets/images/svg/16.svg" alt="p2">
                        </div>
                        <div class="transaction-details">
                          <div class="transaction-name">
                            <h5><?php echo ucwords($typesb) ?></h5>
                            <h3 class="<?php echo $color; ?>"><?php echo $symbol ?><?php echo number_format((int)$amount, 2) ?></h3>
                          </div>
                          <div class="d-flex justify-content-between">
                            <h5 class="<?php echo $color ?>"><?php echo $status ?></h5>
                            <h5 class="light-text"><?php echo $bankName ?> | <?php echo $date ?></h5>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
                <?php
              }
            }
          } else {
            ?>
            <div class="row gy-3">
              <div class="col-12">
                <li class="d-flex justify-content-between align-items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-primary"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                  <span class="text-start">No history found!</span>
                </li>
              </div>
            </div>
            <?php
          }
          ?>
        </div>

        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
          <?php
          $sql = $link->prepare("SELECT * FROM withdrawals WHERE username=? AND type='activity' ORDER BY id DESC LIMIT 5");
          $sql->bind_param("s", $username);
          $sql->execute();
          $result = $sql->get_result();
          $numrow = $result->num_rows;

          if ($numrow > 0) {
            while ($row = $result->fetch_assoc()) {
              $type = $row['type'];
              $amount = $row['amount'];
              $date = $row['date'];
              $status = $row['status'];
              $statusColor = "";
              if ($status == "pending") {
                $statusColor = "text-warning";
              } elseif ($status == "rejected") {
                $statusColor = "text-danger";
              } elseif ($status == "successful") {
                $statusColor = "value text-success";
              }
              $symbol = "NP";
              ?>
              <div class="row gy-3">
                <div class="col-12">
                  <div class="transaction-box">
                    <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
                      <div class="transaction-image">
                        <img class="img-fluid transaction-icon" src="/Flowtrex/user/mPay/assets/images/svg/16.svg" alt="p2">
                      </div>
                      <div class="transaction-details">
                        <div class="transaction-name">
                          <h5><?php echo ucwords($type) ?></h5>
                          <h3 class="<?php echo $statusColor; ?>"><?php echo number_format((int)$amount, 2) ?><?php echo $symbol ?></h3>
                        </div>
                        <div class="d-flex justify-content-between">
                          <h5 class="<?php echo $statusColor ?>"><?php echo $status ?></h5>
                          <h5 class="light-text"><?php echo $bankName ?> | <?php echo $date ?></h5>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            ?>
            <div class="row gy-3">
              <div class="col-12">
                <li class="d-flex justify-content-between align-items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-primary"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                  <span class="text-start">No history found!</span>
                </li>
              </div>
            </div>
            <?php
          }
          ?>
        </div>

        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
          <?php
          $sql = $link->prepare("SELECT * FROM withdrawals WHERE username=? AND type='social' ORDER BY id DESC LIMIT 5");
          $sql->bind_param("s", $username);
          $sql->execute();
          $result = $sql->get_result();
          $numrow = $result->num_rows;

          if ($numrow > 0) {
            while ($row = $result->fetch_assoc()) {
              $type = $row['type'];
              $amount = $row['amount'];
              $date = $row['date'];
              $status = $row['status'];
              $statusColor = "";
              if ($status == "pending") {
                $statusColor = "text-warning";
              } elseif ($status == "rejected") {
                $statusColor = "text-danger";
              } elseif ($status == "successful") {
                $statusColor = "value text-success";
              }
              $symbol = "NP";
              ?>
              <div class="row gy-3">
                <div class="col-12">
                  <div class="transaction-box">
                    <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
                      <div class="transaction-image">
                        <img class="img-fluid transaction-icon" src="/Flowtrex/user/mPay/assets/images/svg/16.svg" alt="p2">
                      </div>
                      <div class="transaction-details">
                        <div class="transaction-name">
                          <h5><?php echo ucwords($type) ?></h5>
                          <h3 class="<?php echo $statusColor; ?>"><?php echo number_format((int)$amount, 2) ?><?php echo $symbol ?></h3>
                        </div>
                        <div class="d-flex justify-content-between">
                          <h5 class="<?php echo $statusColor ?>"><?php echo $status ?></h5>
                          <h5 class="light-text"><?php echo $bankName ?> | <?php echo $date ?></h5>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            ?>
            <div class="row gy-3">
              <div class="col-12">
                <li class="d-flex justify-content-between align-items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-primary"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                  <span class="text-start">No history found!</span>
                </li>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Placeholder spans for JavaScript -->
  <span id="spanOne"></span>
  <span id="spanTwo"></span>

  <script>
    const selectReferral = document.querySelector('#mySelectReferral');
    const selectActivity = document.querySelector('#mySelectActivity');
    const spanOne = document.querySelector('#spanOne');
    const spanTwo = document.querySelector('#spanTwo');

    selectReferral.addEventListener('change', function () {
      if (this.checked) {
        spanOne.style.display = 'none';
        spanTwo.style.display = 'inline';
      }
    });

    selectActivity.addEventListener('change', function () {
      if (this.checked) {
        spanOne.style.display = 'inline';
        spanTwo.style.display = 'none';
      }
    });
  </script>
</section>



<?php include "inc/footer2.php" ?>