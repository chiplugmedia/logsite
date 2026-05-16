<?php 
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
include "actions/currency_rates.php" ;

$ptitle="Earnings History";
include "inc/eader21.php" ;



?>
<!-- Modal -->
         
<div class="notification-area">
      <div class="container">
 <section class="section-b-space">
    <div class="custom-container">
        <div class="title">
             <div><?php echo $genMsg?></div>
        </div>

        <div class="standard-tab">
    <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
        <li class="transaction-name" role="presentation">
            <button class="btn active" id="bootstrap-tab" data-bs-toggle="tab" data-bs-target="#bootstrap" type="button" role="tab" aria-controls="bootstrap" aria-selected="true">Affiliate History</button>
        </li>
        <li class="transaction-name" role="presentation">
            <button class="btn" id="pwa-tab" data-bs-toggle="tab" data-bs-target="#pwa" type="button" role="tab" aria-controls="pwa" aria-selected="false">Activity History</button>
        </li>
    </ul>

    <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">
        <div class="tab-pane fade active show" id="bootstrap" role="tabpanel" aria-labelledby="bootstrap-tab">
            <?php
            $sql = $link->prepare("SELECT * FROM userearnings WHERE username=? AND (type='Affiliate Bonus' OR type='Indirect Affiliate Bonus' OR type='2nd Indirect Affiliate Bonus' OR type='Spillover Bonus') ORDER BY id DESC");
            $sql->bind_param("s", $username);
            $sql->execute();
            $result = $sql->get_result();
            $numrow = $result->num_rows;

            if ($numrow > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $type = $row['type'];
                    $amount = $row['amount'];
                    $date = $row['date'];

                    $color = "";
                    $symbol = "";

                    if ($type == "Daily Flow Login bonus" || $type == "Cashback Bonus" || $type == "Noxen Post" || $type == "Social task" || $type == "Daily Claim" || $type == "P2P Registration" || $type == "Flow Weekly gifts You have earned $amount6 reward Cash.") {
                        $color = "success-color";
                        $symbol = "NP";
                    } elseif ($type == "Indirect Affiliate Bonus" || $type == "Affiliate Bonus" || $type == "2nd Indirect Affiliate Bonus" || $type == "Spillover Bonus") {
                        $color = "success-color";
                        $symbol = "₦";
                    } else {
                        $color = "error-color";
                        $symbol = "";
                    }
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
                                            <h5><?php echo $type ?></h5>
                                            <h3 class="<?php echo $color; ?>"><?php echo $symbol . $amount; ?></h3>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h5 class="<?php echo $color; ?>">Credit</h5>
                                            <h5 class="light-text"><?php echo $date; ?></h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="tab-pane fade" id="pwa" role="tabpanel" aria-labelledby="pwa-tab">
            <?php
            $sql = $link->prepare("SELECT * FROM userearnings WHERE username=? AND (type='Noxen Post' OR type='Cashback Bonus' OR type='Daily Login' OR type='Social task' OR type='Daily Claim' OR type='Activity funds transferred to VTU Balance' OR type='P2P Registration' OR type='Noxen Brain Teaser(quiz) You have earned $amount6 reward Point.') ORDER BY id DESC");
            $sql->bind_param("s", $username);
            $sql->execute();
            $result = $sql->get_result();
            $numrow = $result->num_rows;

            if ($numrow > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $type = $row['type'];
                    $amount = $row['amount'];
                    $date = $row['date'];

                    $color = "";
                    $symbol = "";

                    if ($type == "Noxen Post" || $type == "Daily Login" || $type == "Cashback Bonus" || $type == "Social task" || $type == "Daily Claim" || $type == "Noxen Brain Teaser(quiz) You have earned $amount6 reward points.") {
                        $color = "success-color";
                        $symbol = "+NP";
                    } elseif ($type == "P2P Registration" || $type == "Activity funds transferred to VTU Balance") {
                        $color = "error-color";
                        $symbol = "-NP";
                    } else {
                        $color = "error-color";
                        $symbol = "";
                    }
                    $got = ($type == "P2P Registration" || $type == "Activity funds transferred to VTU Balance") ? "Debit" : "Credit";
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
                                            <h5><?php echo $type ?></h5>
                                            <h3 class="<?php echo $color; ?>"><?php echo $symbol . $amount; ?></h3>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h5 class="<?php echo $color; ?>"><?php echo $got; ?></h5>
                                            <h5 class="light-text"><?php echo $date; ?></h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>




        
        
        
        <?php include "inc/footer2.php" ?>