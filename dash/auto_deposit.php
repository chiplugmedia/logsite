<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/flutterwave/pay.php";



$ptitle="Auto Deposit";
include "inc/header2.php" ?>


 <div class="pc-container">
    <div class="pc-content">
        <div><?php echo $genMsg?></div>
       <!-- Fund Wallet Form (Left) -->
    <div class="fund-wallet-form" style="flex: 1; min-width: 300px;">
        <div class="p-3">
            <form id="fundWalletForm" class="auth-form pt-0 mt-3" method="post" enctype="multipart/form-data">
                <div class="card-body" style="background-color: #fff; padding: 20px; border-radius: 15px;">
                    <h6>Enter Amount (NGN)</h6>
                    <input type="hidden" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <div class="p-3">
                    <button type="submit" name="pay" style="display: block; text-align: center;" class="buy-btn w-100" id="btn-confirm">
                        Send Money
                    </button>
                </div>
            </form>
        </div>
    </div>
<script>
    document.getElementById('fundWalletForm').addEventListener('submit', function (event) {
        const email = event.target.email.value.trim();
        const amount = event.target.amount.value.trim();

        if (!email || !amount || isNaN(amount) || amount <= 0) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a valid email and a positive amount!',
            });
        }
    });
</script>


		<?php include "inc/footer2.php" ?>