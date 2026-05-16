<?php
// Assuming your sendResponse and filter_string functions are defined.
if (isset($_POST['checkCoupon'])) {
    // Check if a coupon is provided
    if (isset($_POST['coupon'])) {
        $coupon = filter_string($_POST['coupon']);

        // Check if the coupon is not empty
        if (!empty($coupon)) {
            $sqlCheckCoupon = $link->prepare("SELECT * FROM coupons WHERE coupon=?");
            $sqlCheckCoupon->bind_param("s", $coupon);
            $sqlCheckCoupon->execute();
            $resultCoupon = $sqlCheckCoupon->get_result();
            $numrow_coupon = $resultCoupon->num_rows;

            if ($numrow_coupon > 0) {
                // Check if the coupon is valid and not used
                $sqlCheckUsedCoupon = $link->prepare("SELECT * FROM coupons WHERE coupon=? AND status='active'");
                $sqlCheckUsedCoupon->bind_param("s", $coupon);
                $sqlCheckUsedCoupon->execute();
                $resultUsedCoupon = $sqlCheckUsedCoupon->get_result();
                $numrow_UsedCoupon = $resultUsedCoupon->num_rows;

                if ($numrow_coupon > 0) {
                    // Update the coupon status to 'used'
                    $sqlUpdateCoupon = $link->prepare("UPDATE coupons SET status='used' WHERE coupon=?");
                    $sqlUpdateCoupon->bind_param("s", $coupon);
                    $sqlUpdateCoupon->execute();

                    $status = "success";
                    $message = "Coupon successfully used";
                } else {
                    $status = "error";
                    $message = "Coupon has already been used";
                }
            } else {
                $status = "error";
                $message = "Invalid coupon";
            }
        } else {
            $status = "error";
            $message = "Coupon is empty";
        }
    } else {
        $status = "error";
        $message = "Coupon not provided";
    }

    // Send response
    $genMsg = sendResponse($status, $message);
}
?>