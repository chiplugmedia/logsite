<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/upgrade.php";
$ptitle="Packages Updates";


include "inc/header2.php" ?>
<div class="pc-container">
    <div class="pc-content">
        <div class="dashboard-body__content">
                    <div><?php echo $genMsg?></div>

            

 <script src="https://korablobstorage.blob.core.windows.net/modal-bucket/korapay-collections.min.js"></script>

<div class="container-fluid">
    <div class="row size-column">
        <div class="col-xl-6 col-md-12 box-col-12">
            <div class="card boost-up-card overflow-hidden">
                <div class="p-4">
                    <form id="korapayForm">
                        <div class="form-group">
                            <label for="amount">Amount (NGN):</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount in NGN" required>

                            <input type="hidden" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>

                            <input type="hidden" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>
                        <button type="button" style="background: #f65365; border: 0; color: white;" class="btn btn-main btn-lg w-100 pill p-3" onclick="payKorapay()">Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function payKorapay() {
        const amountField = document.getElementById("amount");
        const usernameField = document.getElementById("username");
        const emailField = document.getElementById("email");

        const amount = parseInt(amountField.value, 10); // Amount in NGN
        const username = usernameField.value.trim();
        const email = emailField.value.trim();

        if (!amount || amount <= 0) {
            alert("Please enter a valid amount!");
            return;
        }

        if (!username || !email) {
            alert("Please fill in all fields.");
            return;
        }

        window.Korapay.initialize({
            key: "pk_test_ZPmmhg1Z3wbLM5zWTwDEG9pLThN9hggYdQtXSHU8", // Replace with your public key
            reference: generateUniqueReference(),
            amount: amount, // Amount in NGN
            currency: "NGN",
            customer: {
                name: username, // Customer's name
                email: email // Customer's email
            },
            notification_url: "dash/actions/korapay/process.php", // Replace with your webhook URL
            onSuccess: function (response) {
                console.log("Payment Successful:", response);
                alert("Payment Successful!");
                // Optionally, you can redirect or handle the success more robustly
                // window.location.href = "success-page.html";
            },
            onClose: function () {
                console.log("Payment modal closed");
            },
            onError: function (error) {
                console.error("Payment error:", error);
                // Display the error message if any
                alert("An error occurred during payment: " + (error.message || "Please try again later."));
            }
        });
    }

    function generateUniqueReference() {
        // Generate a unique reference dynamically using the current time
        return "ref_" + new Date().getTime();
    }
</script>



<?php include "inc/footer2.php" ?>