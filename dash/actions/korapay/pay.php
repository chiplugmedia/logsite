<?php
$genMsg="";

// Function to generate a unique reference
function generateUniqueReference($length = 12) {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}

// Handle payment request
if (isset($_POST['pay'])) {
    if (!empty($_POST['amount']) && !empty($_POST['email'])) {
        // Sanitize and validate inputs
        $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $usernameby = $_SESSION['username'];

        // Define minimum and maximum amounts
        $min_amount = 1000; // Minimum amount in NGN
        $max_amount = 500000; // Maximum amount in NGN

        // Check if the amount is within the specified range
        if ($amount < $min_amount || $amount > $max_amount) {
            $status = "error";
            $message = "Minimum Deposit is " . number_format($min_amount);
            $genMsg = sendResponse($status, $message); // Generate the response message
            echo json_encode(['status' => $status, 'message' => $message]);
        } else {
            // Generate a unique transaction reference
            $reference = generateUniqueReference(12);

            // Include the Korapay script in HTML
            echo '
            <script>
                function payKorapay() {
                    window.Korapay.initialize({
                        key: "pk_test_ZPmmhg1Z3wbLM5zWTwDEG9pLThN9hggYdQtXSHU8", // Replace with your public key
                        amount: ' . ($amount * 100) . ', // Amount in kobo (e.g., 22000 = NGN 220.00)
                        currency: "NGN",
                        customer: {
                            name: "' . $usernameby . '", // Replace with the actual customer name
                            email: "' . $email . '", // Replace with the actual customer email
                        },
                        notification_url: "https://youngacctsocials.com/dash/actions/korapay/process.php?reference=' . $reference . '", // Replace with your webhook URL
                        onSuccess: function (response) {
                            console.log("Payment successful:", response);
                        },
                        onError: function (error) {
                            console.log("Payment error:", error);
                        },
                        onClose: function () {
                            console.log("Payment modal closed");
                        }
                    });
                }

                // Trigger payment modal on page load
                payKorapay();
            </script>';
        }
    } else {
        $status = "error";
        $message = 'Amount and email are required.';
        $genMsg = sendResponse($status, $message); // Generate the response message
    }
} else {
    $status = "error";
    $message = 'Invalid request.';
    $genMsg = sendResponse($status, $message); // Generate the response message
}






?>