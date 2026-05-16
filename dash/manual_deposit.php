<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/fundwallet.php";



$ptitle="Manual Cash Deposit";
include "inc/header2.php" ?>

                
    
<div class="pc-container">
    <div class="pc-content">
        <div><?php echo $genMsg?></div>
        
   <style>
    .copy-btn {
        float: right;
        background-color: #19bf64;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
    }

    .copy-btn:hover {
        background-color: darkgoldenrod;
    }
</style>

<div class="balance-info">
    <div class="funds-card">

        <div class="bill-price mb-3">
            <h5 class="feature-title">
                Bank -
                <?php echo htmlspecialchars($flwSecretKey, ENT_QUOTES, 'UTF-8'); ?>
            </h5>
            <button
                class="copy-btn"
                type="button"
                onclick="copyToClipboard('<?php echo htmlspecialchars($flwSecretKey, ENT_QUOTES, 'UTF-8'); ?>')">
                Copy
            </button>
        </div>

        <div class="bill-price mb-3">
            <h5 class="feature-title">
                Account Name -
                <?php echo htmlspecialchars($flwPublicKey, ENT_QUOTES, 'UTF-8'); ?>
            </h5>
            <button
                class="copy-btn"
                type="button"
                onclick="copyToClipboard('<?php echo htmlspecialchars($flwPublicKey, ENT_QUOTES, 'UTF-8'); ?>')">
                Copy
            </button>
        </div>

        <div class="bill-price">
            <h5 class="feature-title">
                Account Number -
                <?php echo htmlspecialchars($paymentAccount, ENT_QUOTES, 'UTF-8'); ?>
            </h5>
            <button
                class="copy-btn"
                type="button"
                onclick="copyToClipboard('<?php echo htmlspecialchars($paymentAccount, ENT_QUOTES, 'UTF-8'); ?>')">
                Copy
            </button>
        </div>

    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                const alertBox = document.getElementById("copyAlert");
                alertBox.style.display = "block";

                setTimeout(() => {
                    alertBox.style.display = "none";
                }, 2000);
            })
            .catch(err => {
                console.error("Copy failed:", err);
            });
    }
</script>

<div id="copyAlert"
     class="alert alert-success text-center"
     style="display:none; position:fixed; top:20px; right:20px; z-index:9999;">
    Copied to clipboard ✔
</div>

<!-- Fund Wallet Form -->
<div class="fund-wallet-form">
    <div class="p-3">
        <form class="auth-form pt-0 mt-3" method="post" enctype="multipart/form-data">
            
            <input type="hidden" name="bankTransferFunding" value="1">
            <input type="hidden" name="paymentMethod" value="manual">

            <div class="card-body" style="background-color:#fff;padding:20px;border-radius:15px;">
                
                <label class="mb-1">Enter Amount (NGN)</label>
                <input type="number" name="amount" class="form-control mb-3" required>

                <label class="mb-1">Sender Name</label>
                <input type="text" name="sendername" class="form-control mb-3" placeholder="Enter sender name" required>

                <label class="mb-1">Proof of Payment</label>
                <input type="file"
                       name="paymentProof"
                       accept="image/*"
                       class="form-control"
                       required>
            </div>

            <div class="p-3">
                <button type="submit" class="buy-btn w-100" style="display: block; text-align: center;" id="btn-confirm">
                    Proceed
                </button>
            </div>

        </form>
    </div>
</div>


<?php include "inc/footer2.php" ?>